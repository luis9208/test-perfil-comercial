const cors = require('cors');
const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT;
app.use(express.static(__dirname+'/dist/front'));

app.get('/*', (req, res) => {
    res.sendFile(path.join(__dirname+'/dist/front/index.html'));
});
app.listen(PORT || 8080)