import axios, { RawAxiosRequestHeaders } from "axios";

export class HttpProvider {
  laravelServerUrl: string = "http://localhost:8000/api";
  /**
   * Make a GET request
   *
   * @param route string
   * @param headers RawAxiosRequestHeaders
   *
   * @returns Promise of a Generic type
   */
  async get<T>(route: string, headers?: RawAxiosRequestHeaders): Promise<T> {
    try {
      const results = await axios.get(this.laravelServerUrl + route, {
        headers,
      });
      return results.data;
    } catch (err: any) {
      return Promise.reject(err.message);
    }
  }

  /**
   * Make a POST request
   *
   * @param route string
   * @param body any
   * @param headers RawAxiosRequestHeaders
   *
   * @returns Promise of a Generic type
   */
  async post<T>(
    route: string,
    body: any,
    headers?: RawAxiosRequestHeaders
  ): Promise<T> {
    try {
      const results = await axios.post(this.laravelServerUrl + route, body, {
        headers,
      });
      return results.data;
    } catch (err: any) {
      return Promise.reject(err.message);
    }
  }
}
