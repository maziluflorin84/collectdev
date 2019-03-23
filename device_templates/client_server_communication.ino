#include <SoftwareSerial.h>
#include <WiFiEsp.h>
#include <WiFiEspClient.h>
#include <WiFiEspServer.h>
#include <WiFiEspUdp.h>

char ssid[] = "Miruna";
char pass[] = "breniuc2312";

const byte rxPin = 6;
const byte txPin = 7;

SoftwareSerial ESP8266(rxPin, txPin);

int status = WL_IDLE_STATUS;
int flag = 0;

char server[] = "students.info.uaic.ro";
String uri = "/~florin.mazilu/collectdev/esppost.php";

WiFiEspClient client;

class Value {
  public:
    String element;
    int value;
};

void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600);
  ESP8266.begin(9600);
  WiFi.init(&ESP8266);

  if (WiFi.status() == WL_NO_SHIELD) {
    Serial.println("WiFi shield not present");
    // don't continue
    while (true);
  }

  // attempt to connect to WiFi network
  while (status != WL_CONNECTED) {
    Serial.print("Attempting to connect to WPA SSID: ");
    Serial.println(ssid);
    //connect
    status = WiFi.begin(ssid, pass);
  }

  Serial.println("You're connected to the network");
  
  printWifiStatus();

  Serial.println();
  Serial.println("Starting connection to server...");

  Value value1;
  value1.element = "temperature";
  value1.value = 12;
  Value value2;
  value2.element = "humidity";
  value2.value = 30;
  Value value3;
  value3.element = "proximity";
  value3.value = 200;
  int numOfValues = 3;
  Value values[numOfValues] = {value1, value2, value3};
//  String data = "{\"value\": " + String(val) + "}";
  
  // if you get a connection, report back via serial
  if (client.connect(server, 80)) {
    Serial.println("Connected to server");
    client.print("GET " + uri + "?");
    for (int index = 0; index < numOfValues; index++) {
      Value val = values[index];
      client.print(val.element + "=" + String(val.value));
      if (index < numOfValues - 1)
        client.print("&");
    }
    client.println(" HTTP/1.1");
    
    client.println("Host: students.info.uaic.ro");
    client.println("Connection: close");
    client.println();

    Serial.println("\nResponse from server");
  }
}

void loop() {
  if (client.available()) {
    char c = client.read();
    Serial.write(c);
    flag = 1;
  }

  // if the server's disconnected, stop the client
  if (flag == 1) {
    if (!client.connected()) {
      Serial.println();
      Serial.println("Disconnecting from server...");
      client.stop();
//      do nothing forevermore
//      while (true);
      flag = 0;
    }
  }
}

void printWifiStatus()
{
  // print the SSID of the network you're attached to
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength
  long rssi = WiFi.RSSI();
  Serial.print("Signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}
