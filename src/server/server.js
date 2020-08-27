require('./config/config');

const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const colors = require('colors');

const app = express();

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(express.static(path.resolve(__dirname, '../public')));
app.use(require('./routes/index'));

app.listen(process.env.PORT, () => {
    console.log(`Escuchando puerto: ${ process.env.PORT }`.blue);
});