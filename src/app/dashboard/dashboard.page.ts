import { Component, OnInit } from '@angular/core';

import {ReceiveService} from '../receive.service';
import {SendService} from '../send.service';
import {TransactionsService} from '../transactions.service';

import { Observable } from 'rxjs/Observable';

import { Router } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.page.html',
  styleUrls: ['./dashboard.page.scss'],
})
export class DashboardPage implements OnInit {
   balance:any;
   total_send:any;
   total_receive:any;
  constructor(public receiveService:ReceiveService,
              public sendService:SendService,
              public transactionsService:TransactionsService) {

                this.loadDashboard();

               }

  ngOnInit() {
  }


  loadDashboard(){

     let body_data = {
                  'agent_users_id':localStorage.getItem('user_id')                  
                  };
    event.stopPropagation();   
    
    this.transactionsService.getTotalTransactions(body_data).subscribe(data=>{
        if(data[0].status=='success'){
           this.balance = data[0].total;
        }
    });
    
    this.sendService.getTotalSend(body_data).subscribe(data=>{
        if(data[0].status=='success'){
           this.total_send = data[0].send_total;
        }
    });


    this.receiveService.getTotalReceive(body_data).subscribe(data=>{
        if(data[0].status=='success'){
           this.total_receive = data[0].receive_total;
        }
    });


   

  }

}
