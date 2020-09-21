#include "SR04.h"
#include "WiFi.h"
#include <ArduinoHttpClient.h>
#define TRIG_PIN 12
#define ECHO_PIN 11
SR04 sr04 = SR04(ECHO_PIN, TRIG_PIN);
long a;
bool occupied = false;
String input = String();

const char* ssid = "ssid";
const char* password = "password";
const char serverAddress* = "server_local_ip";
const int port = 8080;

WiFiClient wifi;
HttpClient client = HttpClient(wifi, serverAddress, port);


void setup() {
  Serial.begin(115200);

  WiFi.begin(ssid, password);
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  delay(1000);
}

void loop() {
  a = sr04.Distance();
  if (a < 7) {
    if (WiFi.status() == WL_CONNECTED) {
      client.get("/occupybath1");
    }
    occupied = true;
    while (occupied) {
      a = sr04.Distance();
      if (a >= 7) {
        occupied = false;
        if (WiFi.status() == WL_CONNECTED) {
          client.get("/freebath1");
        }
      }
    }
  }
  delay(100);
}
