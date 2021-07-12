**MAMS**

Das Measurement and Management System ist eine auf PHP und mySQL basierende Software zur Überwachung von Raumtemperatur, Luftfeuchtigkeit und vielen weiteren messbaren Werten.

Das Measurement and Management System kurz MAMS bietet bereits eine Vielzahl an Features, welche in einem Websystem zusammengefasst sind.

Die Überwachung der Sensoren auf der Plattform einer Webseite ermöglicht ihnen den Zugriff auf die Messdaten, von +berall aus auf der Welt über das Internet. Sie können außerdem aus der ferne prüfen, ob Sie vergessen haben das Licht im Flur auszuschalten, und dieses bequem per SmartPhone nachholen.

**Konfiguration:**

Die Konfiguration für die Datenbank und den Pfad erfolgt in der Datei configuration.php.
Die Konfiguration der jeweiligen Elemente erfolgt in der Datenbank, das Menü dafür gibt es aktuell nur zum Verschieben der Reihenfolge dieser Elemente. Anlegen und Löschen geht imo. nur manuell direkt über die Datenbank.
Die jeweiligen Arten von Elementen können in system_config.php mit vielen weiteren Parametern eingestellt werden.

**Login:**

Der Login mit den Beispieldaten erfolgt über:
Username: admin
Password: admin

**Fremde Quellen:**

In dieser Entwicklung sind einige andere Fremde Quellen verwendet worden:
- Smarty-3.1.18
- colorPicker
- flot-0.8.3
- jquery-2.1.1.min
- jquery-ui-1.11.0.min
- jquery-ui-slider-pips-1.5.5
- jquery.gridster.dustmoo
- jquery.gridster
- jscolor
- wz_tooltip
- Eddleman's SecureSessionHandler https://gist.github.com/eddmann/10262795

**Daemon:**

Der Daemon welcher im Hintergrund läuft und die Daten verarbeitet kann mit /var/www/mams/daemon.php ausgeführt werden.

**Webseitendump**
Ein Dump der alten Webseite ist unter http://florian-asche.github.io/MaMS/webpage_dump/ zu finden.

**Lizenz:**

This project is under MIT License.