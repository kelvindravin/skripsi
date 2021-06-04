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

//Turbidity MJKDZ
int turbidity = A1;
float turbiditasAir;

void setup() {
  Serial.begin(9600);
  xbee.begin( 9600 );
  
  Serial.print("Calibrating Node B Sensors...\n");  
  Serial.print( "Data transmission ready! Please wait for Node B Calibration...\n" ); 
  delay(1000);
  Serial.print("Calibration is complete...\n"); 
}

void loop() {
 int measurings=0;
  for (int i = 0; i < samples; i++)
  {
    measurings += analogRead(pHSense);
    delay(10);
  }
    float pHVoltage = 5 / adc_resolution * measurings/samples;
    float turbidityVoltage = 5 / adc_resolution * analogRead(turbidity);
    
    phAir = ph(pHVoltage);
    turbiditasAir = turbiditas(turbidityVoltage);
    
    Serial.println("pH : " + String(phAir));
    Serial.println("turbiditas : " + String(turbiditasAir) + " turbiditasV : " + String(turbidityVoltage));
    
    xbee.print(" P" + String(phAir) + " K" + String(turbiditasAir));
    
    delay(1000);
}

float ph (float voltage) {
  return 7 + ((2.5 - voltage) / 0.18) + correction;
}

float turbiditas(float voltage){
  float result;
  result = ( -900 * voltage ) + 2980;
  
  if(result > 3000){
    result = 3000;
  }else if(result < 0){
    result = 0;
  }

  return result;
}
