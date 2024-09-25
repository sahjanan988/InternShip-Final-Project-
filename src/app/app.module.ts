import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppComponent } from './app.component';
import { CommonModule } from '@angular/common'; // Import CommonModule
@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    CommonModule // Add CommonModule to imports
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }


