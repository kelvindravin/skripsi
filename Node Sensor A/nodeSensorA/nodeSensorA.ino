// Usually COM 3
// DHT-11
#include "DHT.h"
DHTPIN 2
DHTTYPE DHT11

DHT dht(DHTPIN, DHTTYPE);

//MQ-2

//attributes
#define MQ_PIN (0)
#define RL_VALUE (5)
#define RO_CLEAN_AIR_FACTOR (9.83)
#define CALIBARAION_SAMPLE_TIMES (50)
#define CALIBRATION_SAMPLE_INTERVAL (500)
#define READ_SAMPLE_INTERVAL (50)
#define READ_SAMPLE_TIMES (5)
#define GAS_LPG (0)
#define GAS_CO (1)
#define GAS_SMOKE (2)

//Curve for MQ-2, according to the MQ-2 documentation
float LPGCurve[3]  =  {2.3,0.21,-0.47};
float COCurve[3]  =  {2.3,0.72,-0.34};
float SmokeCurve[3] = {2.3,0.53,-0.44};                            
float Ro =  10;

//Xbee
#include <SoftwareSerial.h>
SoftwareSerial xbee( 18, 19 );

void setup() {
  Serial.begin(9600);
  xbee.begin( 9600 );
  
  Serial.print("Calibrating Node A Sensors...\n");  
  Serial.print( "Data transmission ready! Please wait for Node A Calibration...\n" );             
  Ro = MQCalibration(MQ_PIN);
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

  // Compute heat index in Fahrenheit (default)
  float hif = dht.computeHeatIndex(f, h);
  // Compute heat index in Celsius (isFahreheit = false)
  float hic = dht.computeHeatIndex(t, h, false);

    humiditas = h;
    temperatur = t;

  //MQ-2
    kadarLPG = MQGetGasPercentage(MQRead(MQ_PIN)/Ro,GAS_LPG);
    kadarCO = MQGetGasPercentage(MQRead(MQ_PIN)/Ro,GAS_CO);
    kadarAsap = MQGetGasPercentage(MQRead(MQ_PIN)/Ro,GAS_SMOKE);
    
  //Xbee Communication
  String hasil = " H" + String(humiditas) + " T" + String(temperatur) + " L" + String(kadarLPG) + " C" + String(kadarCO) + " A" + String(kadarAsap);
  Serial.println(hasil);
  xbee.print(hasil);
  delay(10000);
}

//Methods for MQ-2

float MQResistanceCalculation(int raw_adc)
{
  return ( ((float)RL_VALUE*(1023-raw_adc)/raw_adc));
}

float MQCalibration(int mq_pin)
{
  int i;
  float val=0;
  for (i=0;i<CALIBARAION_SAMPLE_TIMES;i++) {
    val += MQResistanceCalculation(analogRead(mq_pin));
    delay(CALIBRATION_SAMPLE_INTERVAL);
  }
  val = val/CALIBARAION_SAMPLE_TIMES;
  val = val/RO_CLEAN_AIR_FACTOR;                        
  return val; 
}

float MQRead(int mq_pin)
{
  int i;
  float rs=0;
 
  for (i=0;i<READ_SAMPLE_TIMES;i++) {
    rs += MQResistanceCalculation(analogRead(mq_pin));
    delay(READ_SAMPLE_INTERVAL);
  }
 
  rs = rs/READ_SAMPLE_TIMES;
 
  return rs;  
}

int MQGetGasPercentage(float rs_ro_ratio, int gas_id)
{
  if ( gas_id == GAS_LPG ) {
     return MQGetPercentage(rs_ro_ratio,LPGCurve);
  } else if ( gas_id == GAS_CO ) {
     return MQGetPercentage(rs_ro_ratio,COCurve);
  } else if ( gas_id == GAS_SMOKE ) {
     return MQGetPercentage(rs_ro_ratio,SmokeCurve);
  }    
 
  return 0;
}

int  MQGetPercentage(float rs_ro_ratio, float *pcurve)
{
  return (pow(10,( ((log(rs_ro_ratio)-pcurve[1])/pcurve[2]) + pcurve[0])));
}
