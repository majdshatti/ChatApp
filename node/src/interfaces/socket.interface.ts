interface ServerToClientEvents {
  msgToClient: (key: string, message: string) => void;
}

interface ClientToServerEvents {
  sendMessage: (message: string) => void;
}

interface InterServerEvents {
  ping: () => void;
}

interface SocketData {
  senderId: string;
  receiverId: string;
  token: string;
}

export {
  ServerToClientEvents,
  ClientToServerEvents,
  InterServerEvents,
  SocketData,
};
