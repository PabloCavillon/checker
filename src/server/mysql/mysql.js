const mysql = require('mysql');

const connection = mysql.createPool({
    connectionLimit: process.env.CONNECTION_LIMIT,
    host: process.env.HOST,
    user: process.env.USER,
    passwork: process.env.PASS,
    database: process.env.DB
});

module.exports = connection;