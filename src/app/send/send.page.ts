import { Component, OnInit } from '@angular/core';


import {SendService} from '../send.service';
import {TransactionsService} from '../transactions.service';

import { Observable } from 'rxjs/Observable';

import { Router } from '@angular/router';


@Component({
  selector: 'app-send',
  templateUrl: './send.page.html',
  styleUrls: ['./send.page.scss'],
})
export class SendPage implements OnInit {
    phone_no: string = '';
    amount: string = '';
    balance:string ='';
  constructor(public sendservice:SendService,public transactionsService:TransactionsService,public router: Router) { 
      this.getTotalTransactions();
  }

  ngOnInit() {
  }
   
  getTotalTransactions(){
     let body_data = {
                  'agent_users_id':localStorage.getItem('user_id')
                  }; 
     this.transactionsService.getTotalTransactions(body_data).subscribe(data=>{
        if(data[0].status=='success'){
           this.balance = data[0].total;
        }
     });
  }
  

  sendMoney(){
    let phone_no = this.phone_no;
    let amount = this.amount;
    if(this.balance<amount){
       alert("Balance is not enough");
       return;
    }
    let body_data = {
                  'agent_users_id':localStorage.getItem('user_id'),
                  'phone_no':phone_no,
                  'amount':amount
                  };
    event.stopPropagation();              
    this.sendservice.sendMoney(body_data).subscribe(data=>{
        if(data[0].status=='success'){
            alert("Money has been sent successfully");
            this.router.navigate(['/dashboard']);
        }
    });
  }

}
