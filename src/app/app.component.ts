import { Component, OnInit } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {HttpClient} from '@angular/common/http';
import { JsonPipe } from '@angular/common';



@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css',
 
  
})
export class AppComponent  implements OnInit{
  title = 'MY-ANGULAR-PROJECT';
  readonly ROOT_URL = 'https://jsonplaceholder.typicode.com';
  posts : any ;
  constructor (private http: HttpClient){}
  getposts(){
    this.posts = this.http.get(this.ROOT_URL + '/posts')
  }
  ngOnInit() {
    // ...
  }
}
