import { Component, OnInit } from '@angular/core';

import {ReceiveService} from '../receive.service';
import { Observable } from 'rxjs/Observable';

import { Router } from '@angular/router';


@Component({
  selector: 'app-receive',
  templateUrl: './receive.page.html',
  styleUrls: ['./receive.page.scss'],
})
export class ReceivePage implements OnInit {
   receive:any;
  constructor(public receiveservice:ReceiveService) { 
      this.getAllReceivedMoney();
  }

  ngOnInit() {
  }

  getAllReceivedMoney(){
     let body_data = {
                  'agent_users_id':localStorage.getItem('user_id')
                  };
    this.receiveservice.getReceivedMoney(body_data).subscribe(data=>{
            this.receive = data;
             console.log(data);
        });
  }

  releaseMoney(each){ 
    let body_data = {
                  'agent_users_id':localStorage.getItem('user_id'),
                  'id':each.id,
                  'amount':each.amount
                  };
    event.stopPropagation();   
    this.receiveservice.releaseMoney(body_data).subscribe(data=>{
        if(data[0].status=='success'){
            this.getAllReceivedMoney();
            alert("Release has been sent successfully");
        }
    });
  }


}
