
from locust import HttpUser, task, between, events
import random


USERS = [
    {"email": "aleja@gmail.com", "password": "1234"},
    {"email": "santi@gmail.com", "password": "1234"},
]

class GatewayUser(HttpUser):
    wait_time = between(1, 3)  # tiempo entre acciones por usuario virtual

    def on_start(self):
        """Login y guardar token por cada usuario virtual"""
        creds = random.choice(USERS)
        with self.client.post("/api/login", json=creds, name="/api/login", catch_response=True) as resp:
            if resp.status_code == 200:
                data = resp.json()
                # Ajusta según el formato que devuelva tu gateway:
                self.token = data.get("token") or data.get("access_token")
                if not self.token:
                    resp.failure("No se obtuvo token en la respuesta")
            else:
                resp.failure(f"Login falló: {resp.status_code} {resp.text}")
                self.token = None

    def auth_headers(self):
        return {"Authorization": f"Bearer {self.token}"} if getattr(self, "token", None) else {}

    @task(5)
    def listar_habitaciones(self):
        self.client.get("/api/rooms", headers=self.auth_headers(), name="/api/rooms")

    @task(2)
    def crear_reserva(self):
        payload = {
            "user_id": random.randint(1, 200),
            "room_id": random.randint(1, 50),
            "check_in_date": "2025-10-20",
            "check_out_date": "2025-10-21"
        }
        with self.client.post("/api/reservations", json=payload, headers=self.auth_headers(), name="/api/reservations", catch_response=True) as r:
            if r.status_code not in (200, 201):
                r.failure(f"Reserva fallo: {r.status_code} {r.text}")

    @task(1)
    def listar_reservas(self):
        self.client.get("/api/reservations", headers=self.auth_headers(), name="/api/reservations")
