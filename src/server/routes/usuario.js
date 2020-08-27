const express = require('express');
const bcrypt = require('bcrypt');
const _ = require('underscore');
const { verificaToken } = require('../middlewares/autenticacion');
const connection = require('../mysql/mysql');

const app = express();

app.get('/usuario', function(req, res) {
    connection.getConnection(function(error, tempConn) {
        if (error) {
            tempConn.release();
            console.log('Ocurrió un error', error);
        } else {
            tempConn.query("SELECT * FROM usuario", function(error, rows, fields) {
                if (error) {
                    console.log('Error in the query', error);
                }
                res.json({
                    ok: true,
                    rows
                });
            });
        }
    });
});

module.exports = app;