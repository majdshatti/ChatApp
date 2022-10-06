import express from "express";
// Colors
import colors from "colors";
// Cross-Origin Resource
import cors from "cors";
// Middlewares
import { errorHandler } from "./middleware/errorHandler";
// Services
import { socketConnection } from "./socket-io";

const app = express();

// Server
const httpServer = require("http").Server(app);

// Enable Cross-Origin Resource Sharing
app.use(cors());

// Body parser
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Socketing
socketConnection(httpServer);

// Error handling middleware
app.use(errorHandler);

// Start listening
const PORT = process.env.PORT || 3000;
const server = httpServer.listen(PORT, () => {
  console.log(
    colors.yellow.bold(
      `Server running in ${process.env.NODE_ENV} mode on port ${PORT}`
    )
  );
});

// Catch unhandled promises errors
process.on("unhandledRejection", (err: Error, promise) => {
  console.log(`Error ${err.message}`);
  server.close(() => process.exit(1));
});

// Catch un caught exceptions
process.on("uncaughtException", (err: Error) => {
  console.log(`Error ${err.message}`);
  server.close(() => process.exit(1));
});
