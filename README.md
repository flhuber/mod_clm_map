# mod_clm_map
Vereinskarte für CLM

# CLM-Kartenmodul
## Voraussetzungen

### CLM-Version
Für die Verwendung des CLM Kartenmoduls wird mind. CLM 4.2.1 vorausgesetzt. 

### Koordinaten
Es werden nur Adressen angezeigt, für welche Koordinaten hinterlegt sind. Dafür muss in der CLM-Hauptkomponente der Kartendienst unter Einstellungen->Externe Dienste->Kartendienste aktiviert sein. Wurde diese Funktion erstmals aktiviert, so sind noch keine Koordinaten der Vereins- oder Spiellokale hinterlegt und ein manuelles Anstoßen der Abfrage ist notwendig. Dafür in der CLM-Hauptkomponente unter Vereine bzw. Mannschaften alle Vereine selektieren und auf den Button "Kartendaten aktualisieren" klicken. Vereine/Mannschaften für die keine Auflösung der Adresse möglich war werden angezeigt und die Adresse muss korrigiert werden.

### Saison
Es können nur Vereine/Mannschaften der aktuellen Saison angezeigt werden. Daher ist es notwendig, dass in der CLM-Hauptkomponente eine Saison als Veröffentlicht gesetzt wird, diese nicht im Archiv ist und in dieser Vereine/Mannschaften angelegt sind.

### DWZ Datenbank Update
Für die Möglichkeit nur Vereine eines Bezirk- oder Landesverbandes anzuzeigen, muss zuvor in der CLM-Hauptkomponente die DWZ-Datenbank aktualisiert werden.
  
## Konfiguration
### Karteneinstellungen
#### Kartengröße
Die Kartenhöhe kann in Pixel eingestellt werden, die Weite passt sich an die Modulposition an. 

#### Padding und Zoom

Der angezeigte Kartenausschnitt versucht alle Adressen zu zentrieren, sollten einzelne Marker dennoch nicht komplett angezeigt werden oder größerer Kartenausschnitt gewünscht werden, kann das Padding angepasst werden. Das Padding wird jedoch auch vom eingestellten Zoomsnap beeinflusst. Hier hilft nur etwas rumprobieren, da die Einstellungskombination einerseits von der Kartenfläche und andererseits vom Benutzerwunsch abhängt.
Mit der Zoomabstufung kann die Feinheit des Zooms konfiguriert werden. 

#### Popup-Modus
Im Popup wird der verlinkte Name des Vereins oder der Mannschaft anzeigt. Das Popup lässt sich entweder durch Klick oder beim drüber fahren mit der Maus (Mouseover) öffnen.

#### (0,0)-Koordinaten entfernen

Mannschaften und Vereine für welche die Auflösung von Koordinaten nicht erfolgreich war (z.B. aufgrund fehlerhafter Adresse) werden im Atlantischen Ozean nahe der afrikanischen Westküste angezeigt (Koordinaten (0,0)). Dies ist für eine Fehlersuche hilfreich, im Produktivbetrieb ist aber die aktive Einstellung "(0,0)-Koordinaten entfernen" empfehlenswert.

### Anzeigeeinstellungen
Es können entweder Mannschaften oder Ligen auf der Karte dargestellt werden.

#### Anzeige von Mannschaften einer Liga oder mehrere Ligen
Hierfür muss der Modus "Mannschaften" aktiviert sein, im Feld "Wähle Liga" können anschließend eine oder mehrere Ligen (STRG-Taste gedrückt halten und mehrere Ligen selektieren) gewählt werden.
Für den Ort der Mannschaften wird das hinterlegte Spiellokal der Mannschaft verwendet.
Sind mehrere Ligen selektiert ist es möglich die Farbe der Mannschaftsmarker einheitlich ("Keine Gruppierung") oder abhängig von der Liga in der die Mannschaft spielt ("Farbliche Unterscheidung der Ligen") zu gestalten. 

#### Anzeige von Vereinen
Für die Anzeige von Vereinen muss der Modus "Vereine" unter Anzeigeeinstellungen gewählt werden.
Sollen alle Vereine angezeigt werden, welche in der CLM-Hauptkomponente angelegt sind, muss unter "Gruppierung der Vereine" "Keine Gruppierung" gewählt werden.
Darüber hinaus ist eine Gruppierung auf Bezirks-, Regional- oder Landesebene möglich, dabei haben alle Vereine deselben Verbands auf der Karte dieselbe Markerfarbe. Es ist eine Mehrfachauswahl durch gedrückt halten der STRG-Taste möglich.
Die Einsortierung der Vereine in die Ebenen funktioniert über die ZPS-Nummer und die DWZ-Datenbank, welche auch die Verbandsstruktur bereitstellt: Verbände, welche direkt dem Deutschen Schachbund untergeordnet sind, finden sich in der Landesebene wieder. Verbände, welche einem Landesverband zugeordnet sind, finden sich in der Regionalebene wieder und Verbände, welche einem Regionalverband angehöhren, schließlich auf der Bezirksebene. 

## Fehlerbehebung
### Marker sind im Ozean nahe Afrika
Ist die Koordinatenabfrage für eine Adresse in der CLM-Hauptkomponente fehlerhaft, wird die Koordinate (0,0) für die Kartendarstellung verwendet. Dieser Punkt liegt im Atlantischen Ozean nahe der afrikanischen Westküste. Die Adresse sollte in der CLM-Hauptkomponente korrigiert werden, dadurch wird auch eine neue Koordinatenabfrage angestoßen. Unter Umständen entspricht die Adresse nicht dem definierten Adressformat. Näheres dazu im [CLM-Wiki](https://clm4.de/der-administrationsbereich/item/188-kartenanzeige-verein-mannschaft). (0,0)-Koordinaten können auch in den Moduleinstellungen entfernt werden.

### Es werden keine Marker auf der Karte angezeigt
Mögliche Fehlerursachen:
- Es sind keine Vereine oder Mannschaften in der CLM-Hauptkomponente angelegt.
- Die Vereine bzw. Mannschaften haben keine hinterlegten Koordinaten. Ist der Kartendienst in den Einstellungen aktiviert? Wurden die Koordinaten zu den Adressen abgefragt (siehe oben)?

### Es werden nicht alle Vereine/Spiellokale angezeigt
Es werden nur Vereine und Spiellokale angezeigt für welche eine Adresse und Koordinaten gespeichert werden. Beim Ändern der Adresse durch einen Administrator oder eines Benutzers werden bei aktivierten Kartendienst die Koordinaten umgewandelt. Unter Umständen wird dabei eine Fehlermeldung angezeigt -> Falsche Adresse oder falsches Adressformat. Es können in der CLM-Hauptkomponente unter Vereine oder Mannschaften alle Einträge selektiert werden und durch Klick auf den Button "Kartendaten aktualisieren" die Koordinaten aktualisiert werden. Fehlerhafte Einträge werden angezeigt.

### Der gesetzte Marker entspricht nicht der angegebenen Adresse
Für die Auflösung der Adresse in Koordinaten wird standardmäßig [OSM](https://www.openstreetmap.org/) verwendet. Es sind insbesondere nicht alle Hausnummern einer Straße hinterlegt, sodass der Marker nicht exakt der hinterlegten Adresse entspricht. Die OSM bietet die Möglichkeit zur [Fehlermeldung](https://wiki.openstreetmap.org/wiki/DE:Fehler_melden) an.

### Nach einem Saisonwechsel stimmt die Karte nicht mehr
Für einen Saisonwechsel zuerst die Saison anlegen und anschließend die Vereine und Mannschaften. Nachfolgend muss das Kartenmodul ggf. neu konfiguriert werden. In der Regel reicht dazu das Aufrufen der Moduleinstellungen und das erneute Speichern aus.

### Ich kann keine Liga auswählen
Es müssen zuerst Ligen in der CLM-Hauptkomponente ausgewählt werden. Es können nur Ligen der aktuellen Saison angezeigt werden.

### Es werden keine Bezirke oder Landesverbände angezeigt
Es müssen in der CLM-Hauptkomponente Vereine des Verbandes in der aktuellen Saison angelegt worden sein. Außerdem muss eine (einmalige) Abfrage der DWZ-Datenbank durchgeführt worden sein.

### Der angezeigte Kartenausschnitt ist zu klein oder zu groß
Mit den Einstellungen Padding und Zoom kann der dargestellte Kartenausschnitt angepasst werden. Die optimale Einstellung ist individuell.

