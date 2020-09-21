/*
STAUTS LEGEND
0: Available
1: Booked
2: Occupied
3: In need of sanification
4: Sanification in progress
*/

#include "SR04.h"
#define TRIG_PIN 12
#define ECHO_PIN 11
SR04 sr04 = SR04(ECHO_PIN,TRIG_PIN);
long a;
bool occupied = false;

void setup() {
  Serial.begin(9600);
  delay(1000);
}

void loop() {
  a=sr04.Distance();
  if (a < 7){
    Serial.println("2e"); //Send status "Occupied" when sensor detects a presence in the restroom
    occupied = true;
    while (occupied){
      a=sr04.Distance();
      if (a >= 7){
        occupied = false;
        Serial.println("3e"); //Send status "In need of sanification" when the sensors no longer detects a presence in the restroom
        }
      }
  }
  delay(100);
}


