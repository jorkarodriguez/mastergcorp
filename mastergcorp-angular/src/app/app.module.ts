import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {FormsModule} from '@angular/forms';
import {HttpClient,HttpHeaders} from'@angular/common/http';

import{ Routing ,appRoutingProviders} from './app.ruting';
import {  AppComponent } from './app.component';
import { LoginComponent } from './Components/login/login.component';
import { RegisterComponent } from './Components/register/register.component';
import { HomeComponent } from './Components/home/home.component';
import { ErrorComponent } from './Components/error/error.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    HomeComponent,
    ErrorComponent
  ],
  imports: [
    BrowserModule,
    Routing,
    FormsModule,

  ],
  providers: [
    appRoutingProviders,
    HttpClient,

  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
