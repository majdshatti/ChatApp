# ChatApp

## Introduction

A simple chat-app that provides real-time chatting through node.js/socket.io server and database operations handling through laravel framework.

## Usage Guide

First you need to clone the repository

```
git clone https://github.com/majdshatti/ChatApp.git
```

Start express server

```
cd node
npm install
npm run dev
```

Start laravel server

```
cd laravel
composer install
php artisan serve
```

And finally migrate tables to the DB, type in the same laravel directory

```
php artisan migrate
```

In order to use socket.io first you need to make a request to:
`http://localhost:3000?receiverId=examleid2234da3r32`
Then to send a message to a user make sure to emit an event on `sendMessage` listener with the payload of a string.
and to receive incoming message from a user listen to event `msgToClient` which returns a payload of a string.

## Laravel API Endpoints

- URL: http://localhost:8000

### Un Authenticated User Endpoints

| HTTP Verbs | Endpoints     | Action                         |
| ---------- | ------------- | ------------------------------ |
| POST       | /api/register | Create a new user account      |
| POST       | /api/login    | Login an existing user account |

### Authenticated Endpoints

#### User Endpoints

| HTTP Verbs | Endpoints | Action             |
| ---------- | --------- | ------------------ |
| GET        | /api/user | Retrieve all users |

#### Contact Endpoints

| HTTP Verbs | Endpoints         | Action                       |
| ---------- | ----------------- | ---------------------------- |
| POST       | /api/contact      | Add a contact to a user      |
| DELETE     | /api/contact/{id} | Delete a contact from a user |

#### Messages Endpoints

| HTTP Verbs | Endpoints                | Action                                               |
| ---------- | ------------------------ | ---------------------------------------------------- |
| GET        | /api/message             | Retrieve all message                                 |
| GET        | /api/message?user=id     | Retrieve all message the is sent from specified user |
| GET        | /api/message?search=smth | Retrieve all message that contains 'smth'            |

#### Nodejs Socket.IO Endpoints

Note that you need to send a header `authorization` and has the value of a token

| WebSocket | Endpoints                           | Action                                      |
| --------- | ----------------------------------- | ------------------------------------------- |
| Socket.IO | http://localhost:3000?receiverId=id | Here where the connection to socket is made |

## Technologies Used

- [NodeJS](https://nodejs.org/) This is a cross-platform runtime environment built on Chrome's V8 JavaScript engine used in running JavaScript codes on the server. It allows for installation and managing of dependencies and communication with databases.
- [ExpressJS](https://www.expresjs.org/) This is a NodeJS web application framework.
- [Socket.io](https://socket.io) Socket.IO is an event-driven library for real-time web applications.
- [Laravel](https://laravel.com/) Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
- [SQL]() SQL is a domain-specific language used in programming and designed for managing data held in a relational database management system, or for stream processing in a relational data stream management system.

## Authors

- [Majd Al-Shatti](https://github.com/majdshatti)
