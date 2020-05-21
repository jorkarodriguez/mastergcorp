import { Component, OnInit } from '@angular/core';
import { User } from '../../models/user';
import {UserServices} from '../../services/user.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserServices]

})
export class RegisterComponent implements OnInit {

  public page_title: string;
  public user: User;
  constructor(
    public _UserService:  UserServices

  ) {
    this.page_title = 'Registrate';
    this.user = new User(1, '', '');
  }

  ngOnInit(): void {


    console.log('componente de registro lanzado')
  }

  onSubmit(form) {

    console.log(this.user);
    console.log(this._UserService.test());

    form.reset();
  }

}
