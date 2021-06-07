// Usually COM 3
// DHT-11
#include "DHT.h"
#define DHTPIN 2
#define DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

//MQ-2
#include <MQ2.h>
int pin = A0;
MQ2 mq2(pin);

//Xbee
#include <SoftwareSerial.h>
SoftwareSerial xbee( 18, 19 );

void setup() {
  Serial.begin(9600);
  xbee.begin( 9600 );
  
  Serial.print("Calibrating Node A Sensors...\n");  
  Serial.print( "Data transmission ready! Please wait for Node A Calibration...\n" );             

  delay(25000);
 
  mq2.begin();
  dht.begin();
  Serial.print("Calibration is complete...\n"); 
}

void loop() {
  float humiditas;
  float temperatur;
  float kadarLPG;
  float kadarCO;
  float kadarAsap;
  
  //DHT-11
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  float f = dht.readTemperature(true);

  if (isnan(h) || isnan(t) || isnan(f)) {
    Serial.println(F("Failed to read from DHT sensor!"));
    return;
  }

    humiditas = h;
    temperatur = t;

  //MQ-2
    kadarLPG = mq2.readLPG();
    kadarCO = mq2.readCO();
    kadarAsap = mq2.readSmoke();
    
  //Xbee Communication
  String hasil = " H" + String(humiditas) + " T" + String(temperatur) + " L" + String(kadarLPG) + " C" + String(kadarCO) + " A" + String(kadarAsap);
  Serial.println(hasil);
  xbee.print(hasil);
  delay(6000);
}
