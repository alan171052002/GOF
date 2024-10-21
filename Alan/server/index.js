const express = require("express");
const app = express();
const mysql = require("mysql");
const cors = require("cors");
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken");

app.use(cors());
app.use(express.json());

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "envios"
});

db.connect((err) => {
    if (err) {
        throw err;
    }
    console.log("Conectado a la base de datos MySQL");
});

const secretKey = "A17052002m"; // Cambia esto a una clave secreta segura

// Registro de usuario
app.post("/register", async (req, res) => {
    const { user_name, Nombre, Departamento, password } = req.body;
    const hashedPassword = await bcrypt.hash(password, 10);

    db.query('INSERT INTO usuarios (user_name, Nombre, Departamento, password) VALUES (?, ?, ?, ?)', 
        [user_name, Nombre, Departamento, hashedPassword],
        (err, result) => {
            if (err) {
                console.log(err);
                res.status(500).send("Error al registrar usuario");
            } else {
                res.send(result);
            }
        }
    );
});

// Login de usuario
app.post("/login", (req, res) => {
    const { user_name, password } = req.body;

    db.query('SELECT * FROM usuarios WHERE user_name = ?', [user_name], async (err, result) => {
        if (err) {
            console.log(err);
            res.status(500).send("Error en el servidor");
        } else if (result.length === 0) {
            res.status(401).send("Usuario no encontrado");
        } else {
            const user = result[0];
            const isPasswordValid = await bcrypt.compare(password, user.password);
            if (isPasswordValid) {
                const token = jwt.sign({ user_id: user.id, user_name: user.user_name }, secretKey, { expiresIn: '1h' });
                res.json({ token });
            } else {
                res.status(401).send("Contraseña incorrecta");
            }
        }
    });
});

// Middleware para verificar el token
// Middleware para verificar el token
const verifyToken = (req, res, next) => {
    const token = req.headers['authorization'];
    if (!token) {
        return res.status(403).send("Se requiere un token");
    }
    jwt.verify(token, secretKey, (err, decoded) => {
        if (err) {
            return res.status(401).send("Token inválido");
        }
        req.user = decoded;
        next();
    });
};


app.post("/create", (req, res) => {
    const { cliente, paqueteria, observaciones, con_emb } = req.body;

    db.query('INSERT INTO envios (cliente, paqueteria, observaciones, con_emb) VALUES (?, ?, ?, ?)', 
        [cliente, paqueteria, observaciones, con_emb],
        (err, result) => {
            if (err) {
                console.log(err);
            } else {
                res.send(result);
            }
        }
    );
});

app.get("/envios", (req, res) => {
    db.query('SELECT * FROM envios', (err, result) => {
        if (err) {
            console.log(err);
        } else {
            res.send(result);
        }
    });
});

app.put("/update/:id", (req, res) => {
    const { id } = req.params;
    const { cliente, paqueteria, observaciones, con_emb } = req.body;

    db.query('UPDATE envios SET cliente=?, paqueteria=?, observaciones=?, con_emb=? WHERE id=?',
        [cliente, paqueteria, observaciones, con_emb, id],
        (err, result) => {
            if (err) {
                console.log(err);
            } else {
                res.send(result);
            }
        }
    );
});

app.delete("/delete/:id", (req, res) => {
    const { id } = req.params;

    db.query('DELETE FROM envios WHERE id=?', id, (err, result) => {
        if (err) {
            console.log(err);
        } else {
            res.send(result);
        }
    });
});

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
    console.log(`Servidor backend corriendo en el puerto ${PORT}`);
});

app.put("/envios/:id/estado", (req, res) => {
    const { id } = req.params;
    const { estado } = req.body;
    const hora_estado = new Date(); // Obtener la hora actual

    db.query('UPDATE envios SET estado = ?, hora_estado = ? WHERE id = ?', [estado, hora_estado, id], (err, result) => {
        if (err) {
            console.log(err);
            res.status(500).send("Error al actualizar el estado del envío");
        } else {
            res.send(result);
        }
    });
});