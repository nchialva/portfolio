# 🌐 Portfolio Personale - PHP & MySQL

Questo progetto è un **portfolio personale dinamico**, sviluppato con **HTML, CSS, JavaScript, PHP e MySQL**, che presenta il mio profilo professionale, le mie competenze, i miei progetti e la mia esperienza lavorativa.  
Include anche un sistema di autenticazione e una sezione di amministrazione per la gestione dei contenuti.

-----------------------------------------------------------------------------------------------------------------------------------------------------------

## 🧩 Struttura principale

### 🏠 Home
La sezione principale del sito presenta:
- Un **hero** con una breve presentazione personale e un pulsante *"Su di me"*.
- Link diretti al mio **GitHub**, al **Curriculum Vitae (CV)** e al profilo **LinkedIn**.
- Un design moderno e responsive, ottimizzato per diversi dispositivi.

![Screenshot Home](./assets/screen_git/images/screenHome.png)  

-----------------------------------------------------------------------------------------------------------------------------------------------------------

### 💡 Competenze
In questa sezione vengono mostrate le mie **certificazioni** e **skill tecniche**, presentate in modo chiaro e interattivo.

![Sezione Competenze](./assets/screen_git/images/competenze2.png)  
![Skills](./assets/screen_git/skills.png)

-----------------------------------------------------------------------------------------------------------------------------------------------------------

### 🧰 Progetti
Una panoramica dei progetti più rilevanti, con:
- Breve descrizione del progetto.
- Link al **sito live**.
- Link al **repository GitHub** corrispondente.
  
![Progetti](./assets/screen_git/images/progetti.png)
![Progetti](./assets/screen_git/images/progetti2.png)

-----------------------------------------------------------------------------------------------------------------------------------------------------------


### 💼 Esperienza
Dettagli sulle mie **esperienze lavorative** e sul percorso professionale.

![Sezione Esperienza](./assets/screen_git/images/s1.png)  


-----------------------------------------------------------------------------------------------------------------------------------------------------------


### 📬 Contatto
Un modulo che consente ai visitatori di **inviarmi un messaggio direttamente via e-mail**.

![Sezione Contatto](./assets/screen_git/images/contatto.png)  


-----------------------------------------------------------------------------------------------------------------------------------------------------------


### 📰 Notizie
Sezione dedicata alle **notizie o aggiornamenti**, gestita direttamente dall’amministratore tramite pannello backend.



-----------------------------------------------------------------------------------------------------------------------------------------------------------


## 🛠️ Tecnologie utilizzate
- **Frontend:** HTML5, CSS3, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Librerie / Framework:** Bootstrap, PHPMailer  
- **Strumenti di sviluppo:** Visual Studio Code, XAMPP  

-----------------------------------------------------------------------------------------------------------------------------------------------------------

## 🔐 Login

La sezione di **Login** consente agli utenti di **registrarsi, autenticarsi e accedere alle aree riservate** del portfolio.  
Il sistema è stato sviluppato in **PHP** con connessione al database **MySQL** per la gestione sicura delle credenziali.

### ✨ Funzionalità principali
- Registrazione di nuovi utenti con validazione dei dati.  
- Accesso tramite **email e password**.  
- Crittografia delle password mediante **password_hash()** di PHP.  
- Gestione delle sessioni utente.  
- Possibilità di **recupero password** (opzionale).  

### 🧠 Logica del sistema
Il modulo di login verifica le credenziali inviate dal form e confronta i dati con quelli presenti nel database.  
Se le informazioni sono corrette, l’utente viene reindirizzato all’area **User**; in caso contrario, viene mostrato un messaggio di errore.

### 📸 Screenshot
*(Inserire qui le immagini del form di login e registrazione)*  

![Login](./assets/screen_git/images/loggin.png)  
![Registrazione](./assets/screen_git/images/regi.png)

-----------------------------------------------------------------------------------------------------------------------------------------------------------

## 👤 User

La sezione **User** è l’area personale a cui si accede dopo l’autenticazione.  
Permette agli utenti di gestire i propri dati, visualizzare informazioni personalizzate o accedere a contenuti riservati.

### ✨ Funzionalità principali
- Visualizzazione e aggiornamento delle informazioni del profilo.  
- Accesso ai messaggi o notifiche personali.  
- Possibilità di modificare la password.  
- Logout sicuro tramite distruzione della sessione PHP.

### 🧠 Dettagli tecnici
- Gestione delle sessioni utente tramite `$_SESSION`.  
- Protezione delle rotte per impedire l’accesso non autorizzato.  
- Comunicazione con il database per leggere e aggiornare i dati dell’utente.

### 📸 Screenshot
*(Inserire qui le immagini della dashboard utente o delle impostazioni del profilo)*  

![Dashboard User](./assets/screen_git/images/home.png)

-----------------------------------------------------------------------------------------------------------------------------------------------------------


## 💾 SQL

L’applicazione utilizza un database **MySQL** per la gestione delle informazioni relative agli utenti, ai progetti e ai contenuti dinamici del portfolio.

### 🗂️ Struttura del database

Le principali tabelle includono:

- **utenti** → contiene i dati di registrazione e autenticazione (id, nome, email, password, data_registrazione, ruolo).  
- **progetti** → informazioni sui progetti mostrati nella sezione *Progetti* (id, titolo, descrizione, link_sito, link_git).  
- **notizie** → notizie o aggiornamenti gestiti dall’amministratore (id, titolo, testo, data_pubblicazione).  
- **messaggi** → messaggi inviati tramite la sezione *Contatto* (id, nome, email, messaggio, data_invio).

### ⚙️ Caratteristiche tecniche
- Connessione tramite `mysqli` o `PDO` per garantire sicurezza e flessibilità.  
- Uso di **query preparate** per prevenire attacchi di tipo SQL Injection.  
- Possibilità di importare facilmente la struttura del database tramite file `.sql`.

### 📄 Esempio di creazione tabella `utenti`

```sql
CREATE TABLE utenti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
