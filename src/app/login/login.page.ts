import { Component, OnInit } from '@angular/core';

import {LoginService} from '../login.service';
import { Observable } from 'rxjs/Observable';

import { Router } from '@angular/router';


@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  constructor(public loginservice:LoginService,private router: Router) { }

  ngOnInit() {
  }

  login(form){

      let email = form.value.email;
      let password = form.value.password;

     this.loginservice.getLogin(email,password).subscribe(data=>{
               if(data[0].status=='success'){
                   let id = data[0].user.id;
                   //let first_name = data[0].user.first_name;
                   let last_name = data[0].user.last_name;
                   localStorage.setItem('user_id',id);
                   localStorage.setItem('userinfo',JSON.stringify(data[0].user));
                   
                   this.router.navigate(['/dashboard'])


               }
               else if(data[0].status=='fail'){
                     
                  alert("Login fail.Please enter your correct email and password") 

               }

     });
     
  }

}
