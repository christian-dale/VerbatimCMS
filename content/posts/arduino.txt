## Introduction

In this article you will learn about concurrency on the arduino. Concurrency is a way of doing multiple
things on the Arduino seemingly at the same time. This is great for making your code more responsive.  

## Delay vs millis

When doing multiple things on the Arduino, one usually uses the delay() function.
Although this works for simple programs, this function blocks all other code.
Instead, we should be using the millis() function.

The millis() function returns the time in milliseconds since the Arduino started executing code.

## Millis function example

When using the millis() function for concurrency we need to log the time at a certain point,
and then we need to compare this value to the current time by subtracting the current time
with the last time, and check if that is more than or equal to the specified delay.
When we have done this, we can then set the lastTime variable to the current time.

<pre class="code code-block prettyprint"><code>unsigned long lastTime = millis();
unsigned long currentTime = 0;
const int delayTime = 1000;

void start() {
    int test = 10;
}

void loop() {
    currentTime = millis();

    if (currentTime - lastTime >= delay) {
        lastTime = currentTime;
    }
}</code></pre>
                        
                        
                        
                    
                    
                    
                    