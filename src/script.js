var express = require('express');
var mysql = require('mysql');
var app = express();

var connection = mysql.createPool({
    connectionLimit: 50,
    host: 'localhost',
    user: 'root',
    passwork: '',
    database: 'test'
});

app.get('/', function(req, resp) {
    connection.getConnection(function(error, tempConn) {
        if (error) {
            tempConn.release();
            console.log('Error');
        } else {
            console.log('Connected!');
            tempConn.query("SELECT * FROM usuario", function(error, rows, fields) {
                if (error) {
                    console.log('Error in the query');
                }
                resp.json({
                    ok: true,
                    rows
                });
            });
        }
    });
});

app.listen(8080);