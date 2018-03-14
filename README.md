# SerwerSMS - Laravel5

Klient PHP do komunikacji zdalnej z API v2 SerwerSMS.pl

Zalecane jest, aby komunikacja przez HTTPS API odbywała się z loginów utworzonych specjalnie do połączenia przez API. Konto użytkownika API można utworzyć w Panelu Klienta → Ustawienia interfejsów → HTTPS XML API → Użytkownicy.
## Instalacja
Instalacja odbywa się poprzez composer i dodanie do pliku composer.json poniższego kodu:
```php
    {
        "require": {
            "serwer/sms": "dev-master"
        }
        ...
        "repositories" : [{
            "type" : "git",
            "url" : "https://github.com/SerwerSMSpl/serwersms-laravel5.git"
         }],
    }
```
## Wysyłka SMS

app/config/app.php:
```php
    return [
	    ...
	    ...
	    'providers' => [
	        ...
	        ...
	        Serwer\Sms\SmsServiceProvider::class,
	    ]
	    'sms'=>[
        	'username' => 'username',
        	'password' => 'password',
			'api_url'  => 'https://api2.serwersms.pl/',
			'format'   => 'json'
		]
    ]
```
Controller.php
```php

	try{
	
	    $serwersms = new \SMS;
	
	    // SMS FULL
	    $result = $serwersms->messages->sendSms(
	            array(
	                    '+48500600700',
	                    '+48600700800'
	            ),
	            'Test FULL message',
	            'INFORMACJA',
	            array(
	                    'test' => true,
	                    'details' => true
	            )
	    );
	
	    // SMS ECO
	    $result = $serwersms->messages->sendSms(
	            array(
	                    '+48500600700',
	                    '+48600700800'
	            ),
	            'Test ECO message',
	            null,
	            array(
	                    'test' => true,
	                    'details' => true
	            )
	    );
	
	    // VOICE from text
	    $result = $serwersms->messages->sendVoice(
	            array(
	                    '+48500600700',
	                    '+48600700800'
	            ),
	            array(
	                    'text' => 'Test message',
	                    'test' => true,
	                    'details' => true
	            )
	    );
	
	    // MMS
	    $list = $serwersms->files->index('mms');
	    $result = $serwersms->messages->sendMms(
	            array(
	                    '+48500600700',
	                    '+48600700800'
	            ),
	            'MMS Title',
	            array(
	                    'test' => true,
	                    'file_id' => $list->items[0]->id,
	                    'details' => true
	            )
	    );
	
	    echo 'Skolejkowano: '.$result->queued.'<br />';
	    echo 'Niewysłano: '.$result->unsent.'<br />';
	
	    foreach($result->items as $sms){
	        
	        echo 'ID: '.$sms->id.'<br />';
	        echo 'NUMER: '.$sms->phone.'<br />';
	        echo 'STATUS: '.$sms->status.'<br />';
	        echo 'CZĘŚCI: '.$sms->parts.'<br />';
	        echo 'WIADOMOŚĆ: '.$sms->text.'<br />';
	        
	    }
	
	} catch(Exception $e){
	    echo 'ERROR: '.$e->getMessage();
	}
```
Wysyłka spersonalizowanych SMS
```php
	try{
	
	    $serwersms = new \SMS;
	
	    $messages[] = array(
			'phone' => '500600700',
			'text' => 'First message'
	    );
	    $messages[] = array(
			'phone' => '600700800',
			'text' => 'Second message'
	    );
	
	    $result = $serwersms->messages->sendPersonalized(
			$messages,
			'INFORMACJA',
			array(
					'test' => true,
					'details' => true
			)
	    );
	
	    echo 'Skolejkowano: '.$result->queued.'<br />';
	    echo 'Niewysłano: '.$result->unsent.'<br />';
	
	    foreach($result->items as $sms){
	  
	        echo 'ID: '.$sms->id.'<br />';
	        echo 'NUMER: '.$sms->phone.'<br />';
	        echo 'STATUS: '.$sms->status.'<br />';
	        echo 'CZĘŚCI: '.$sms->parts.'<br />';
	        echo 'WIADOMOŚĆ: '.$sms->text.'<br />';
	        
	    } 
	
	} catch(Exception $e){
	    echo 'ERROR: '.$e->getMessage();
	}
```
Pobieranie raportów doręczeń
```php
	try{
	
    	    $serwersms = new \SMS;
    	
    	    // Get messages reports
    	    $result = $serwersms->messages->reports(array('id' => array('aca3944055')));
    	
    	    foreach($result->items as $sms){
    	  
    	        echo 'ID: '.$sms->id.'<br />';
    	        echo 'NUMER: '.$sms->phone.'<br />';
    	        echo 'STATUS: '.$sms->status.'<br />';
    	        echo 'SKOLEJKOWANO: '.$sms->queued.'<br />';
    	        echo 'WYSŁANO: '.$sms->sent.'<br />';
    	        echo 'DORĘCZONO: '.$sms->delivered.'<br />';
    	        echo 'NADAWCA: '.$sms->sender.'<br />';
    	        echo 'TYP: '.$sms->type.'<br />';
    	        echo 'WIADOMOŚĆ: '.$sms->text.'<br />';
    	        
    	    }
	
	} catch(Exception $e){
	    echo 'ERROR: '.$e->getMessage();
	}
```
Pobieranie wiadomości przychodzących
```php
	try{
    	    $serwersms = new \SMS;
    	
    	    // Get recived messages
    	    $result = $serwersms->messages->recived('ndi');
    	
    	    foreach($result->items as $sms){
    	  
    	        echo 'ID: '.$sms->id.'<br />';
    	        echo 'TYP: '.$sms->type.'<br />';
    	        echo 'NUMER: '.$sms->phone.'<br />';
    	        echo 'DATA: '.$sms->recived.'<br />';
    	        echo 'CZARNA LISTA: '.$sms->blacklist.'<br />';
    	        echo 'WIADOMOŚĆ: '.$sms->text.'<br />';
    	        
    	    }
	
	} catch(Exception $e){
	    echo 'ERROR: '.$e->getMessage();
	}
```
## Wymagania

php >= 5.3.9

Laravel = 5.*

## Dokumentacja
http://dev.serwersms.pl

Konsola API

http://apiconsole.serwersms.pl/

