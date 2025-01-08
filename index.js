/*const express = require('express')
const speakeasy = require('speakeasy')
const uuid = require('uuid')
const { JsonDB } = require('node-json-db')
const { Config } = require('node-json-db/dist/lib/JsonDBConfig')
 

const app = express()

app.use(express.json())

const db = new JsonDB(new Config('myDatabase', true, false, '/'))

app.get('/api', (req, res) => res.json({ messages: ' Two factor authentication example'}))

// Register user and create temp secret
app.post('/api/register', (req, res) => {
    const id = uuid.v4()

    try{
        const path = '/user/${id}'
        const temp_secret = speakeasy.generateSecret()
        db.push(path, { id, temp_secret })
        res.json( {id, secret: temp_secret.base32 })
    } catch (error){
        console.log(error)
        res.status(500).json({ message: 'Error generating the secret'})
    }
})

// Verify token and make secret perm
app.post('/api/verify', (req, res) => {
    const {token, userid} = req.body
    
    try{
        const path = `/user/${userid}`
        const user = db.getData(path)

        const { base32:secret } = user.temp_secret

        const verified = speakeasy.totp.verify({ secret,
            encoding: 'base32',
            token  });

        if(verified) {
            db.push(path, { id: userid, secret: user.temp_secret })
            res.json({ verified: true })
        } else {
            res.json({ verified: false })
        }        
    } catch (error) {
        console.log(error)
        res.status(500).json({ message: 'Error finding user'})

    }
})

// Validate token
app.post('/api/validate', (req, res) => {
    const {token, userid} = req.body

    // Check if token and userid are provided
    if (!token || !userid) {
        return res.status(400).json({ message: "Token and userid are required" });
    }
    
    try{
        const path = `/user/${userid}`
        console.log(`Fetching user data from path: ${path}`);
        const user = db.getData(path)

        if (!user || !user.secret) {
            throw new Error("User or secret not found in database");
        }

        const { base32:secret } = user.secret

        const tokenValidates = speakeasy.totp.verify({ secret,
            encoding: 'base32',
            token, window: 1 });

            console.log(`Token validation result: ${tokenValidates}`);
            res.json({ validated: tokenValidates });
        } catch (error) {
            console.error("Error details:", error.message);
            res.status(500).json({ message: error.message || 'Error finding user' });
        }
});

const PORT = process.env.PORT || 5000

app.listen(PORT, () => console.log('Server running on port ${PORT}'))





app.get('/add-data', (req, res) => {
    try {
      db.push('/users/1', { id: 1, name: 'John Doe' }, true);
      res.json({ message: 'Data added' });
    } catch (error) {
      res.status(500).json({ message: 'Error adding data', error });
    }
  });
  */
  