#include <LiquidCrystal.h>
#include <dht_nonblocking.h>

// Segment values for displaying numbers 0-9 and the letter 'H'
byte digits[] = {
  0x3F, 0x06, 0x5B, 0x4F, 0x66, 0x6D, 0x7D, 0x07, 0x7F, 0x6F,
  0x00, // Space (all segments off)
  0x76,  // 'H',
  0x63 // for show degree
};
const int photocellPin = A4;  // Photocell connected to A4
const int outputPin = 13;     // Output pin set to digital pin 13
#define DHT_SENSOR_TYPE DHT_TYPE_11
#define FanPin 4 //Output Fan Drive

// Pin definitions for 74HC595
int latchPin = A2; // STCP
int clockPin = A1; // SHCP
int dataPin = A0;  // DS

// Pin definitions for the common cathodes of the 7-segment display
const int DIGIT1 = A3;
const int DIGIT2 = 6;
const int DIGIT3 = 1;
const int DIGIT4 = 3; // Verify that this is the correct pin and is not used for Serial communications
const int buzzer = A5;
int digitPins[4] = {DIGIT1, DIGIT2, DIGIT3, DIGIT4};
bool automat = true,fana = true;
bool fanIsOn = false; // Flag to track the fan state
static const int DHT_SENSOR_PIN = 2; // DHT1 Digital Data
DHT_nonblocking dht_sensor(DHT_SENSOR_PIN, DHT_SENSOR_TYPE);
bool timeflag = false;
int countSevenSeg = 0;
// Initialize the library with the numbers of the interface pins
LiquidCrystal lcd(7, 8, 9, 10, 11, 12);

void setup() {
  pinMode(outputPin, OUTPUT);  // Set the output pin as an OUTPUT
  pinMode(FanPin, OUTPUT);

  Serial.begin(9600);

  lcd.begin(16, 2); // LCD has 16 Character in 2 rows
  // Initialize all the control pins for the 7-segment display
  pinMode(latchPin, OUTPUT);
  pinMode(clockPin, OUTPUT);
  pinMode(dataPin, OUTPUT);
  pinMode(buzzer, OUTPUT);
  for (int i = 0; i < 4; i++) {
    pinMode(digitPins[i], OUTPUT);
    digitalWrite(digitPins[i], HIGH); // Turn off all digits
  }
  digitalWrite(buzzer,LOW);

  // Print a message to the LCD.
  lcd.print("Guard Activated");
  delay(3000);
  //lcd.clear();

}
//__________________________ Loop Main ________________________________
void loop() {
  float temperature;
  float humidity;
  float LightMeasure;

  // Measure temperature and humidity. If a measurement is available, display it.
  if (measure_environment(&temperature, &humidity )) 
  {
    // Update LCD with temperature and humidity
    LightMeasure = LightCheck();
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("T=");
    lcd.print(temperature, 1);
    lcd.print("C H=");
    lcd.print(humidity, 1);
    lcd.print("%");
    
    // Control the fan based on the temperature
    fanControl(temperature);

    // Now display the humidity on the 7-segment display
    if(timeflag == false)
    {
      displayHumidity((int)humidity);
      
    }
    else
    {
      displayTemperature((int)temperature);
    }
  }
  
  if (Serial.available() > 0){
    String command = Serial.readStringUntil('\n');
    Serial.println(command);
    
    delay(10);
    if (command == "GET") {
      Serial.print("Temperature:");
      Serial.print(temperature);
      Serial.print(",Humidity:");
      Serial.println(humidity);
      Serial.print(",Light Measure:");
      Serial.println(LightMeasure);
    
    }
    else{
        int numElements = 1; // Start with 1 element
        for (int i = 0; i < command.length(); i++) 
         {
            if (command[i] == ',')
             {
                numElements++;
             }
         }    
         // Create an array of strings to hold the split results
        String parts[numElements];
       // Variables for splitting the string
      int startIndex = 0;
      int idx = 0;

      for (int i = 0; i < numElements; i++) 
      {
        int endIndex = command.indexOf(',', startIndex);
        if (endIndex == -1) 
            { // Last part of the string
             endIndex = command.length();
            }
    parts[i] = command.substring(startIndex, endIndex);
    startIndex = endIndex + 1;
      }

  // Print the results to the Serial Monitor
  if (parts[1] == "fan")
    if(parts[2] == "1")
    {
      digitalWrite(FanPin,HIGH);
      fana = false;
    }
    else if(parts[2] == "0")
    {
      digitalWrite(FanPin,LOW);
      fana = false;
    }
    else
    {
      fana = true;
    }
  if (parts[3] == "light")
    if(parts[4] == "1")
      {
      digitalWrite(outputPin,HIGH);
      Serial.println(parts[4]);
      automat = false;
      
      }
    else if(parts[4] == "0")
      {
        digitalWrite(outputPin,LOW);
        
        automat = false;
      }
    else
    {
      Serial.println("nothing changed");
      automat = true;
    }
  if (parts[5] == "buzzer")
    if(parts[6] == "1")
      digitalWrite(buzzer,HIGH);
    else if(parts[6] == "0")
      digitalWrite(buzzer,LOW);
    else
      Serial.println("nothing changed");
  
  }
    
}
}


// Function to control fan based on temperature
void fanControl(float temperature) {
  if (fana == true){
    if (temperature >= 22 ) {
      if (!fanIsOn) {
        lcd.clear();
        lcd.print("Fan is on");
        fanIsOn = true;
      }
      Ventilation(true); // Activate the fan
      } else {
        if (fanIsOn) {
         lcd.clear();
         lcd.print("Fan is off");
        fanIsOn = false;
    }
      Ventilation(false); // Deactivate the fan
      }
  }
}

// Function to handle ventilation control
void Ventilation(bool activate) {
  digitalWrite(FanPin, activate ? HIGH : LOW);

}

// Function to display humidity on the 7-segment display
void displayHumidity(int humidity) {
  int tens = humidity / 10;
  int ones = humidity % 10;
  countSevenSeg+=1;
  if(countSevenSeg == 1)
  {
    timeflag = true;
    countSevenSeg = 0;
  }
  for(int i = 0 ;i< 400; i++)
  {
    displayDigit(0, digits[tens]); // Tens place
    displayDigit(1, digits[ones]); // Ones place
    displayDigit(2, digits[10]);   // Space
    displayDigit(3, digits[11]);   // Letter 'H'
    }
}
/////////////////////////////
// Function to display temperature on the 7-segment display
void displayTemperature(int temperature) {
  int tens = temperature / 10;
  int ones = temperature % 10;
  countSevenSeg+=1;
  if(countSevenSeg == 1)
  {
    timeflag = false;
    countSevenSeg = 0;
  }
  for(int i = 0 ;i< 400; i++)
  {
    displayDigit(0, digits[tens]); // Tens place
    displayDigit(1, digits[ones]); // Ones place
    displayDigit(2, digits[10]);   // Space
    displayDigit(3, digits[12]);   // Letter 'degree'
  
  }
}

// Function to display a number on the specified digit
void displayDigit(int digit, byte segments) {
  // Turn off all digits
  for (int i = 0; i < 4; i++) {
    digitalWrite(digitPins[i], HIGH);
  }

  // Set segments for current number
  digitalWrite(latchPin, LOW);
  shiftOut(dataPin, clockPin, MSBFIRST, segments);
  digitalWrite(latchPin, HIGH);
  digitalWrite(digitPins[digit], LOW);

  // Brief delay for persistence of vision
  delay(5);
}
///////////////
static bool measure_environment( float *temperature, float *humidity )
{
  static unsigned long measurement_timestamp = millis( );

  /* Measure once every four seconds. */
  if( millis( ) - measurement_timestamp > 1 )
  {
    if( dht_sensor.measure( temperature, humidity ) == true )
    {
      measurement_timestamp = millis( );
      return( true );
    }
  }

  return( false );
}
float LightCheck() {
  int sensorValue = analogRead(photocellPin);  // Read the value from the photocell
  float voltage = sensorValue * (5.0 / 1023.0); // Convert the value to voltage

  //Serial.print("Voltage: ");
 // Serial.println(voltage);     // Print the voltage to the Serial Monitor

  // Check the voltage level
  Serial.print(voltage);
  Serial.print(automat);
  if (automat==true)  {
     if (voltage > 2.5 )  {
        digitalWrite(outputPin, HIGH); // Set pin 13 to LOW if voltage is more than 2.5V
    }else {
      digitalWrite(outputPin, LOW); // Set pin 13 to HIGH if voltage is less than 2.5V
     }
    }
    return voltage;
    delay(1);  // Delay for a second before reading the value again
}
//}
     
