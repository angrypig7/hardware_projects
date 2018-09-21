#include <SPI.h>
#include <LoRa.h>
#include <SSD1306.h>

#define ss 5
#define rst 14
#define dio0 2

int counter = 0;

void setup(){
    Serial.begin(115200);

    Serial.println("Connected!");
    LoRa.setPins(ss, rst, dio0);
    //433E6 for Asia
    //866E6 for Europe
    //915E6 for North America
    while (!LoRa.begin(866E6)) {
        Serial.println("...");
        delay(500);
    }

    // Change sync word (0xF3) to match the receiver
    // The sync word assures you don't get LoRa messages from other LoRa transceivers
    // ranges from 0-0xFF
    LoRa.setSyncWord(0xF3);
    Serial.println("LoRa Initializing OK!");
}

void loop(){
  counter++;
  Serial.print("Sending packet: ");
  Serial.println(counter);

  //Send LoRa packet to receiver
  LoRa.beginPacket();
  LoRa.print("DATA: ");
  LoRa.print(counter);
  LoRa.endPacket();

  delay(2500);
}