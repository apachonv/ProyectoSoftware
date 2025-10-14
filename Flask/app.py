from flask import Flask, request, jsonify
import smtplib
from email.mime.text import MIMEText
import requests

app = Flask(__name__)

API_KEY="1234"

# Configuración del correo
GMAIL_USER = "bolsos.vargachi@gmail.com"
GMAIL_PASSWORD = "bobcoezrhqphdsff" 

@app.before_request
def verificar_api_key():
    print("llego al flask", flush=True)
    api_key_recibida = request.headers.get("X-API-Key")
    
    if api_key_recibida != API_KEY:
        return jsonify({"message": "Acceso Denegado Desde El Flask"}), 403
    
@app.route('/enviar-mensaje', methods=['POST'])
def send_email():
    mensaje = request.json
    
    try:
        msg = MIMEText(mensaje)
        msg['From'] = GMAIL_USER
        msg['To'] = "apachonv@unal.edu.co"  # destinatario fijo
        msg['Subject'] = "Nueva Reservacion"

        # Conexión SMTP
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(GMAIL_USER, GMAIL_PASSWORD)
        server.sendmail(GMAIL_USER, "apachonv@unal.edu.co", msg.as_string())
        server.quit()
        return jsonify({"message": "Correo enviado correctamente"}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
