import { Component, OnInit } from '@angular/core';

import {TransactionsService} from '../transactions.service';

import { Observable } from 'rxjs/Observable';

import { Router } from '@angular/router';

@Component({
  selector: 'app-transactions',
  templateUrl: './transactions.page.html',
  styleUrls: ['./transactions.page.scss'],
})
export class TransactionsPage implements OnInit {
  transactions:any;
  balance:any;
  constructor(public transactionsService:TransactionsService) {
     this.loadTransactions();
     //this.loadBalance();
   }

  ngOnInit() {
  }

  loadBalance(){
      let body_data = {
                  'agent_users_id':localStorage.getItem('user_id'),
                };
      this.transactionsService.getTotalTransactions(body_data).subscribe(data=>{
        if(data[0].status=='success'){
           this.balance = data[0].total;
          // alert(this.balance);
        }
    });
  }

  loadTransactions(){
       let body_data = {
                  'agent_users_id':localStorage.getItem('user_id'),
                };
       this.transactionsService.getAllTransactions(body_data).subscribe(data=>{
       this.transactions = data;
    }); 
  }

}
