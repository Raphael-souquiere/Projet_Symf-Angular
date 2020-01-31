import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-form-search',
  templateUrl: './form-search.component.html',
  styleUrls: ['./form-search.component.css']
})

export class FormSearchComponent implements OnInit {

  userForm: FormGroup;
  afficheText: string;

  constructor(private fb: FormBuilder,private http: HttpClient) {  }

  ngOnInit() {
    this.userForm = this.fb.group({
      nom : ['oui'],
      site : ['non'],
      typeUser : ['ISEN'],
    });
  }

  register() {
    console.log(this.userForm.value);
    var formData: any = new FormData();
    formData.append("nom", this.userForm.value['nom']);
    formData.append("site", this.userForm.value['site']);
    formData.append("typeUser", this.userForm.value['typeUser']);
  //  this.http.post('127.0.0.1:8000/api/searchuser?nom=',this.userForm.value['nom'] + 'site=', this.userForm.value['site']+ 'typeUser=',this.userForm.value['typeUser'], formData).subscribe(
    //  (response) => console.log(response),
  //    (error) => console.log(error))
  }
}
