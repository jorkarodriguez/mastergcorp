import { Injectable} from '@angular/core';
import {HttpClient,HttpHeaders} from '@angular/common/http';

import{Observable}from 'rxjs';
import {User}from '../Models/user';


@Injectable()
export class UserServices{

  constructor(
    //public _http: HttpClient

  ){

  }

  test(){
    return"hola mundo desde un"
  }
}
