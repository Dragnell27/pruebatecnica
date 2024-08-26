import { Component, OnInit } from '@angular/core';
import { TranslateModule } from '@ngx-translate/core';
import { environment } from '../../../environments/environment';
import { UpperCasePipe } from '@angular/common';
import { Router } from '@angular/router';

//Declaro la variable global para el uso de JQuery
declare var $: any;

@Component({
  selector: 'app-location',
  standalone: true,
  imports: [TranslateModule, UpperCasePipe],
  templateUrl: './location.component.html',
  styleUrl: './location.component.css'
})
export class LocationComponent implements OnInit {

  constructor(private router: Router) { }

  countries: any[] = [];
  cities: any[] = [];

  //Defino una variable para usar el endPoint
  private endPoint = environment.apiUrl;

  // Carga de ciudades en lista dinámica
  ngOnInit(): void {
    $.ajax({
      url: `${this.endPoint}/countries`,
      method: 'GET',
      success: (data: any) => {
        this.countries = data.data

        // Asigna la opción almacenada en el sessionStorage
        setTimeout(() => {
          let select = document.getElementById('countries') as HTMLSelectElement | null;
          if (select) {
            const storedValue = sessionStorage.getItem('country') || '0';
            select.value = storedValue;
            let event = new Event('change', { bubbles: true });
            select.dispatchEvent(event);
          }
        }, 0);
      },
      error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
        console.error('Error:', textStatus, errorThrown);
      }
    });
  }

  //Detecta si hubo un cambio en el selector de países y carga las ciudades
  changeCountry(event: Event) {
    const country = event.target as HTMLInputElement
    sessionStorage.setItem('country', country.value);
    if (country.value) {
      $.ajax({
        url: `${this.endPoint}/cities/${country.value}`,
        method: 'GET',
        success: (data: any) => {
          this.cities = data.data;

          // Asigna la opción almacenada en el sessionStorage
          setTimeout(() => {
            let select = document.getElementById('cities') as HTMLSelectElement | null;
            if (select) {
              const storedValue = sessionStorage.getItem('city') || '0';
              select.value = storedValue;
              let event = new Event('change', { bubbles: true });
              select.dispatchEvent(event);
            }
          }, 0);
        },
        error: (jqXHR: any, textStatus: string, errorThrown: string | Error) => {
          console.error('Error:', textStatus, errorThrown);
        }
      });
    } else {
      this.cities = [];
    }
  }

  //Detecta si hubo un cambio en el selector de ciudades y almacena la opción en el sessionStorage
  changeCity(event: Event) {
    const city = event.target as HTMLInputElement
    sessionStorage.setItem('city', city.value);
  }

  next(event: Event) {
    const alert = document.getElementById('p-alert');

    // Obtén los valores de sessionStorage y conviértelos a números
    const city = sessionStorage.getItem('city') || '0';
    const country = sessionStorage.getItem('country') || '0';

    // Función para mostrar la alerta
    const showAlert = () => {
      if (alert) {
        alert.classList.remove('p-alert-close');
        alert.classList.add('p-alert-open');
        setTimeout(() => {
          alert.classList.remove('p-alert-open');
          alert.classList.add('p-alert-close');
        }, 1500);
      }
    };

    // Verifica si los valores de ciudad o país son inválidos
    if (city === '0' || country === '0') {
      showAlert();
      return
    }

    // Navega a la ruta budget si todos los valores son válidos
    this.router.navigate(['/budget']);
  }
}

