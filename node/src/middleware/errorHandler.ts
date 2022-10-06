import { Request, Response, NextFunction } from "express";
import { ErrorResponse } from "../utils/";
import colors from "colors";

export const errorHandler = (
  err: ErrorResponse,
  req: Request,
  res: Response,
  next: NextFunction
) => {
  console.log(
    colors.red.bold(
      "Name: " + err.name + " Message: " + err.message + " Stack: " + err.stack
    )
  );
  const statusCode = err.statusCode || 500;

  const response = {
    success: false,
    message: err.message,
  };

  res.status(statusCode).json(response);
};
