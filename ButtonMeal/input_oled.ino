#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include "fonts.h"  //kfont, Open_Sans_Hebrew_Condensed_14, Open_Sans_Hebrew_Condensed_18, Open_Sans_Hebrew_Condensed_24
#define OLED_RESET 4
Adafruit_SSD1306 display(OLED_RESET);

#define NUMFLAKES 10
#define XPOS 0
#define YPOS 1
#define DELTAY 2

#if (SSD1306_LCDHEIGHT != 64)
#error("Height incorrect, please fix Adafruit_SSD1306.h!");
#endif

void setup()   {
  Serial.begin(115200);
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);
  // Show image buffer on the display hardware.
  display.display();

  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(10, 0);
  display.clearDisplay();
  display.println("INPUT YOUR TEXT HERE: ");

  display.invertDisplay(true);
  display.invertDisplay(false);
  display.display();
   display.clearDisplay();
}


void loop() {
  while (1) {
    display.setTextSize(1);
    display.setTextColor(WHITE);
    display.setCursor(10, 0);
    display.clearDisplay();
    display.println("input:");
    printText();
    display.display();
    
  }

}

void printText(void) {
  String s;
  if (Serial.available())
  {
    s = Serial.readString();  //getting string input in variable "s"
    display.println(s);
    display.display();
    display.println("\n");
  }
  delay(4000);
}
