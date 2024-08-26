import { Component, OnInit } from '@angular/core';
import { NavigationEnd, Router, RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { LanguageComponent } from './components/language/language.component';
import { TranslateModule } from '@ngx-translate/core';
import { LocationComponent } from './components/location/location.component';
import { environment } from '../environments/environment';
import { DecimalPipe, UpperCasePipe } from '@angular/common';

declare var $: any;

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,DecimalPipe, LanguageComponent, TranslateModule, UpperCasePipe],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  histories: any[] = [];
  private endPoint = environment.apiUrl;

  constructor(private router: Router) {};

  //Detecta la navegación a la pagina principal para cargar el historial.
  ngOnInit(): void {
    this.loadData();
    this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd && event.urlAfterRedirects === '/') {
        this.loadData();
      }
    });
  }

  //Método para el consumo de api que carga el historial
  loadData(): void {
    $.ajax({
      url: `${this.endPoint}/history_show`,
      method: 'GET',
      success: (data: any) => {
        this.histories = data.data;
      },
      error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
        console.error('Error:', textStatus, errorThrown);
      }
    });
  }

  //Evento para el despliegue del historial
  history(event: Event) {
    if (event.target) {
      const history = document.getElementById('history');
      if (history) {
        history.classList.toggle('d-none');
      }
    }
  }
}
