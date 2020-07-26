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
export class TransactionsService {

  constructor(public http: HttpClient) { }
 
  getAllTransactions(data:any):Observable<any>{
      let link = '&agent_users_id='+data.agent_users_id;
      return this.http.get('http://localhost/moneytransfer/index.php/server/serve/?cmd=get_all_transactions'+link);
  } 

  getTotalTransactions(data:any):Observable<any>{
      let link = '&agent_users_id='+data.agent_users_id;
      return this.http.get('http://localhost/moneytransfer/index.php/server/serve/?cmd=get_total_transactions'+link);
  } 

}
