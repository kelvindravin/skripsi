//Xbee
#include <SoftwareSerial.h>
SoftwareSerial xbee( 18, 19 );

// Usually COM 4
//ph-4502C
#include <Arduino.h>
int pHSense = A0;
int samples = 10;
float adc_resolution = 1024.0;
float correction = 2.9;
float phAir;

void setup() {
  Serial.begin(9600);
  xbee.begin( 9600 );
  
  Serial.print("Calibrating Node B Sensors...\n");  
  Serial.print( "Data transmission ready! Please wait for Node B Calibration...\n" ); 
  delay(25000);
  Serial.print("Calibration is complete...\n"); 
}

void loop() {
 int measurings=0;
  for (int i = 0; i < samples; i++)
  {
    measurings += analogRead(pHSense);
    delay(10);
  }
    float voltage = 5 / adc_resolution * measurings/samples;

    phAir = ph(voltage);
    Serial.println(phAir);
    xbee.print(" P" + String(phAir));
    
    delay(10000);
}

float ph (float voltage) {
  return 7 + ((2.5 - voltage) / 0.18) + correction;
}
