const axios = require('axios');

const runSpeciesLinkOperation = async (url, data, method = "GET") => {
  const response = await axios.request({
    url,
    method,
    data,
    headers: {
      "Content-type": "application/json"
    }
  });
  return response.data.result;
};


const start = async (data) => {
    console.log('start')
    var start = new Date()
    const url = 'https://api.splink.org.br/records';
    //const data = {	
    //    "ScientificName" : "Prepusa montana",
    //    "Scope" : "plants",
        // "Coordinates": "Yes",
        // "Images": "Yes",
        // "MaxRecords": "1000",
        //"Format": "JSON"
    //}
    const occ = await runSpeciesLinkOperation(url, data, 'POST');
    var end = new Date() - start
    console.info('Execution time: %d segundos', end/1000)
    console.log(occ.length)
    console.log(occ[0])
    return occ;
}

const express = require('express');
const cors = require('cors');
var fs = require('fs');
var https = require('https');
var privateKey  = fs.readFileSync('../../../../../../../home/marcelojorge/chaveprivada.key', 'utf8');
var certificate = fs.readFileSync('../../../../../../../home/marcelojorge/jbrj.gov.br.crt', 'utf8');
const bodyParser = require('body-parser');

var credentials = {key: privateKey, cert: certificate};

const corsOptions = {
    "origin": true,
    "allowedHeaders": ["Access-Control-Allow-Headers", 
                        "Access-Control-Allow-Origin", 
                        "Origin",
                        "X-Requested-With",
                        "Content-Type",
                        "Accept"],
    "methods": ["GET","HEAD","PUT","PATCH","POST","DELETE"],
    "preflightContinue": false,
    "credentials": true
}

const app = express();

// Automatically allow cross-origin requests
app.use(express.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(cors(corsOptions));

app.get('/splink', async (req, res) => {
  const data = await start(req.query);
  res.send(data);
});

app.post('/splink', (req, res) => {
  //const data = await start();
  res.send();
});

var httpsServer = https.createServer(credentials, app);

httpsServer.listen(8443, () => {
  console.log('Server started.');
});