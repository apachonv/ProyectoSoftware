from flask import Flask, request, jsonify
import smtplib
from email.mime.text import MIMEText

app = Flask(__name__)

# Configuración del correo
GMAIL_USER = "tu_correo@gmail.com"
GMAIL_PASSWORD = "tu_contraseña_de_aplicación"

@app.route('/send-email', methods=['POST'])
def send_email():
    data = request.json  # Recibe los datos desde el request
    nombre = data.get("nombre")
    asunto = data.get("asunto")
    mensaje_extra = data.get("mensaje")

    if not nombre or not asunto or not mensaje_extra:
        return jsonify({"error": "Faltan campos"}), 400

    # Construimos el mensaje dinámico
    mensaje = f"Hola {nombre},\n\n{mensaje_extra}\n\nSaludos,\nEquipo Flask"

    try:
        msg = MIMEText(mensaje)
        msg['From'] = GMAIL_USER
        msg['To'] = "destinatario_fijo@gmail.com"  # destinatario fijo
        msg['Subject'] = asunto

        # Conexión SMTP
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(GMAIL_USER, GMAIL_PASSWORD)
        server.sendmail(GMAIL_USER, "destinatario_fijo@gmail.com", msg.as_string())
        server.quit()

        return jsonify({"status": "Correo enviado"}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
