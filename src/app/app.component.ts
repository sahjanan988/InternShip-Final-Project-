import { Component, OnInit } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import { JsonPipe } from '@angular/common';



@Component({
  selector: 'app-root',
  standalone: true,
  templateUrl: './app.component.html',
  styleUrl: './app.component.css',
})

export class AppComponent  implements OnInit{
  title = 'MY-ANGULAR-PROJECT';
  readonly ROOT_URL = 'https://jsonplaceholder.typicode.com';
  posts : any ;
  constructor (private http: HttpClient){}
  getPosts() {
    this.http.get<any[]>(this.ROOT_URL + '/posts').subscribe(response => {
      this.posts = response;
    });
  }
  ngOnInit(){
    this.getPosts(); // Fetch posts on component initialization
  }
}
export class MyComponent {
  myObject = {
    name: 'John Doe',
    age: 30
  };
}