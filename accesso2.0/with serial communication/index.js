/*
STAUTS LEGEND
0: Available
1: Booked
2: Occupied
3: In need of sanification
4: Sanification in progress
*/
//init
let app = require('express')();
fs = require('fs');
let status = new String('0, 0');
var status1, status2;
status1 = 0;
status2 = 0;

//Functions to read and write status.txt
function saveStatus(status){
    fs.writeFile("status.txt", status, 'utf8', (err)   => {
    if (err) throw err;
    console.log("status saved");
    })
}

function readStatus(){
    return fs.readFileSync("status.txt", 'utf8')
}

//Events that can be called from the app through http requests
app.get('/', (req, res) => {
    res.send('still working');
})

//Event to get the status of both restrooms
app.get('/status', (req, res) => {
    status = ''
    while (status == ''){
    status = readStatus();
}
    res.send(status);
})

//Events to book access to a restroom
app.get('/bookbath1', (req, res) => {
    res.send('bath 1 booked');
    status = readStatus();
    status2 = String(status).charAt(2);
    status1 = 1;
    saveStatus(String(status1) + "," + String(status2));
})

app.get('/bookbath2', (req, res) => {
    res.send('bath 2 booked');
    status = readStatus();
    status1 = String(status).charAt(0);
    status2 = 1;
    saveStatus(String(status1) + "," + String(status2));

})

//Events that can only be called from the janitor app to confirm when a restroom is sanificated
app.get('/cleanbath1', (req, res) => {
    res.send('bath 1 is being cleaned');
    status = readStatus();
    status2 = String(status).charAt(2);
    status1 = 4;
    saveStatus(String(status1) + "," + String(status2));
})

app.get('/cleanbath2', (req, res) => {
    res.send('bath 2 is being cleaned');
    status = readStatus();
    status1 = String(status).charAt(0);
    status2 = 4;
    saveStatus(String(status1) + "," + String(status2));
})

app.get('/cleanedbath1', (req, res) => {
    res.send('bath 1 has been cleaned');
    status = readStatus();
    status2 = String(status).charAt(2);
    status1 = 0;
    saveStatus(String(status1) + "," + String(status2));
})

app.get('/cleanedbath2', (req, res) => {
    res.send('bath 2 has been cleaned');
    status = readStatus();
    status1 = String(status).charAt(0);
    status2 = 0;
    saveStatus(String(status1) + "," + String(status2));
})

app.listen(3000, console.log('Server listening in 3000'));
