import { DecimalPipe, UpperCasePipe } from '@angular/common';
import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { TranslateModule } from '@ngx-translate/core';

@Component({
  selector: 'app-result',
  standalone: true,
  imports: [UpperCasePipe, TranslateModule,DecimalPipe],
  templateUrl: './result.component.html',
  styleUrl: './result.component.css'
})
export class ResultComponent {
  //Extraigo la info de la data final el sessionStorage
  data : any = {};

  constructor(private router: Router){ }

  ngOnInit(): void {
    const storedData = sessionStorage.getItem('data');
    this.data = storedData ? JSON.parse(storedData) : {}; // Convierte la cadena JSON a objeto
  }

  //Tomo el presupuesto den COP para mostrar en la vista
  budget: string | null = sessionStorage.getItem('budget');

  home(){
    sessionStorage.clear();
    this.router.navigate(['']);
  }
}
