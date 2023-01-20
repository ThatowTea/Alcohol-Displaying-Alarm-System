//declsring libraries
#include <LiquidCrystal_I2C.h>
#include <WiFi.h>
#include <Wire.h>
#include <WiFiClient.h>
#include <WiFiServer.h>
#include <WiFiUdp.h>

//initializing intputs and output pinss
int alcSensor = 34 ;
int GreenLED = 4;
//int buttonPin = 2;
int buzzerPin = 15;
int RedLED = 13;
int alcValue; 

LiquidCrystal_I2C lcd(0x27, 16, 2);

//declaring Wifi details
const char* ssid     = "Tee";
const char* password = "NkitsengT#99";

//declarring server
char server[]= "192.168.43.3";
IPAddress ip(192,168,43,3);
WiFiClient client;

void setup()
{
  Serial.begin(9600);
  //Initialize inputs and outputs
  pinMode(GreenLED, OUTPUT);
  pinMode(RedLED, OUTPUT);
//  pinMode(buttonPin, INPUT);
  pinMode(buzzerPin, OUTPUT);
  
  //WiFi connections
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");

  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(500);
  }
  //wifiConnection();
  Serial.println("\nConnected to WiFi network");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // SETUP LCD
  lcd.init(); // set up number of columns and rows
  lcd.backlight();
  lcd.setCursor(0, 0);         // move cursor to   (0, 0)
  lcd.print("!!!Welcome!!!");        // print message at (0, 0)
  lcd.setCursor(0, 1);         // move cursor to   (2, 1)
  lcd.print("Take a Test"); // print message at (2, 1)
  delay(5000);
}

void loop()
{
  digitalWrite(GreenLED, HIGH);

  alcValue = analogRead(alcSensor);
  Serial.print("Alcohol level: ");
  Serial.println(alcValue);
  lcd.clear();
  lcd.setCursor(0, 0);          
  lcd.print("Alc Level: ");
  lcd.print(alcValue);
  if(alcValue > 1300)
  {
    digitalWrite(GreenLED, LOW); 
    digitalWrite(RedLED, HIGH);
    digitalWrite(buzzerPin, HIGH);
    lcd.setCursor(0, 1);          
    lcd.print("High Alc Lvl");
    sendingToDatabase();
    delay(5000);
  }
  else
  {
    //digitalWrite(GreenLED, HIGH);
    //digitalWrite(RedLED, LOW);
    digitalWrite(buzzerPin, LOW);
    lcd.setCursor(0, 1);          
    lcd.print("Low Alc Lvl");  
  }
   digitalWrite(RedLED, LOW);
   digitalWrite(buzzerPin, LOW);

  wifiConnection();
//  inputOutput();
  
  delay(5000);
}

//functions ================================================
void wifiConnection()
{
  //WIFI coding
  if(WiFi.status() == WL_CONNECTED)
  {
    Serial.println("You can try to ping");
    delay(2000);
  }
  else
  {
    Serial.println("Connection lost!");
  }
}



void sendingToDatabase()
{
  if(client.connect(server, 80))
  {
    Serial.println("Connected");
    Serial.println("GET /testcode/phpcode.php?alcohol=");
    client.print("GET /testcode/phpcode.php?alcohol=");
    //Serial.println(" ");
    Serial.println(alcValue);
    client.print(alcValue);
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: 192.168.43.3");
    client.println("Connection: close");
    client.println();
   }  
   else
   {
    Serial.print("Connection failed");
   }
}
