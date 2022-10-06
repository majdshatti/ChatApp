/** Socket.io */
import { Server } from "socket.io";
/** Interfaces */
import {
  ServerToClientEvents,
  InterServerEvents,
  ClientToServerEvents,
  SocketData,
  IHttpResponse,
} from "./interfaces";
/** Service */
import { HttpProvider } from "./services/http.service";

/** List of connected socket clients */
let clients: { userId: string; socketId: string }[] = [];

let io: Server<
  ClientToServerEvents,
  ServerToClientEvents,
  InterServerEvents,
  SocketData
>;

export const socketConnection = (httpServer: any) => {
  /** Initialize Socket IO */
  io = new Server<
    ClientToServerEvents,
    ServerToClientEvents,
    InterServerEvents,
    SocketData
  >(httpServer);

  const httpService = new HttpProvider();

  /** Socket Middleware */
  io.use(async (socket, next) => {
    const token = socket.handshake.headers.authorization;
    const receiverId = socket.handshake.query.receiverId;
    try {
      /** Make GET Request to laravel api */
      const result = await httpService.get<IHttpResponse>(
        `/verify/${receiverId}`,
        {
          Authorization: `Bearer ${token}`,
        }
      );

      // Destructure success result and data from result's data
      const { success, data } = result;

      /** Send sender and receiver ids through socket */
      if (success && data.senderId && data.receiverId) {
        socket.data = {
          senderId: data.senderId,
          receiverId: data.receiverId,
          token,
        };
      }
    } catch (err: any) {
      console.log(err);
    }

    if (!socket.data.receiverId || !socket.data.senderId) {
      return next(new Error("Unauthorized to access this route"));
    }

    next();
  });

  /** Socket Connection */
  io.on("connection", function (socket) {
    console.log(`A client has connect on socket id ${socket.id}`);

    /** Get passed sender and receiver ids from socket */
    const { senderId, receiverId, token } = socket.data;

    /** Assign user to the clients list */
    //? Note that we put `!` because we made sure that senderId and recevierId will not
    //? have the undefined value because it's validated in the io middleware
    assignUser(senderId!, socket.id);

    /** Send a message from sender to receiver user */
    socket.on("sendMessage", async message => {
      try {
        //? Note that even if getUserSocketId wont return a receiver id from current
        //? active socket clients, but in this case we store messages for offline clients
        //? and they receives the messages once they are online
        await httpService.post<IHttpResponse>(
          "/message",
          { message, from: senderId, to: receiverId },
          { Authorization: `Bearer ${token}` }
        );
        io.to(getUserSocketId(receiverId!)).emit("msgToClient", "msg", message);
      } catch (err: any) {
        console.log(err.message);
      }
    });

    socket.on("disconnect", function () {
      console.log(`A client has disconnected from socket id ${socket.id}`);
      unAssignUser(receiverId!);
    });
  });
};

/**
 * Assign user to clients list
 *
 * @param userId
 * @param socketId
 * @returns
 */
const assignUser = (userId: string, socketId: string) => {
  for (const client of clients) {
    if (client.userId === userId) {
      client.socketId = socketId;
      return;
    }
  }
  clients.push({ userId, socketId });
};

/**
 * unAssign user to clients list
 *
 * @param userId
 * @returns boolean
 */
const unAssignUser = (userId: string): boolean => {
  for (let i = 0; i < clients.length; i++) {
    if (clients[i].userId === userId) {
      clients.splice(i, 1);
      return true;
    }
  }
  return false;
};

/**
 * Gets a receiver id from current active clients
 *
 * @param userId
 * @returns string | falsy string
 */
const getUserSocketId = (userId: string): string => {
  for (const client of clients) {
    if (client.userId === userId) {
      return client.socketId;
    }
  }
  return "";
};
