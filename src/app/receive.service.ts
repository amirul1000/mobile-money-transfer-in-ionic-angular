import { Injectable } from '@angular/core';

import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/operator/do';


const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};


@Injectable({
  providedIn: 'root'
})
export class ReceiveService {

  constructor(public http: HttpClient) { }
 
  getReceivedMoney(data:any):Observable<any>{
      let link = '&agent_users_id='+data.agent_users_id;
      return this.http.get('http://localhost/moneytransfer/index.php/server/serve/?cmd=getallreceivedmoney'+link);
  } 
  
  releaseMoney(data:any):Observable<any>{
      let link = '&agent_users_id='+data.agent_users_id+'&id='+data.id+'&amount='+data.amount;
      return this.http.get('http://localhost/moneytransfer/index.php/server/serve/?cmd=releasemoney'+link);
  } 

   getTotalReceive(data:any):Observable<any>{
      let link = '&agent_users_id='+data.agent_users_id;
      return this.http.get('http://localhost/moneytransfer/index.php/server/serve/?cmd=get_total_receive'+link);
  } 

  
}
