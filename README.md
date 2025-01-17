# Ab_project-szte-2023

## Szakdolgozatok
### Specifikáció: 
Egy egyetemi rendszerben adatbázisban tartják nyilván a szakdolgozatokat, a hallgatókat, valamint a témavezetőket és a szakokat. A dolgozatok adatait adminisztrátorok viszik fel. A belső témavezetők listát kapnak az általuk vezetett témákról és módosíthatják a dolgozatok címét. Az adminisztrátorok, témavezetők, hallgatók is felhasználói a rendszernek. Oktatók és hallgatók tudnak regisztrálni a rendszerbe, de külső témavezetők nem, őket az adminisztrátorok veszik fel.

Tárolt adatok (nem feltétlen jelentenek önálló táblákat): 
*	Adminisztrátorok: egyetemi azonosító, jelszó, előtag, név, munkaköri beosztás
*	Témavezetők: egyetemi azonosító, jelszó, előtag, név, munkaköri beosztás, szerepkör, dolgozat azonosítója
*	Hallgatók: egyetemi azonosító, jelszó, előtag, név, jogviszony, dolgozat azonosítója
*	Dolgozatok: dolgozat azonosítója, dolgozat címe, kar, intézet, tanszék, beadás éve, védés éve, védés érdemjegye
*	Hallgatói szakok: hallgató egyetemi azonosítója, szak azonosítója, szak neve, a szakot gondozó kar neve, kezdés szemesztere, végzés szemesztere, diploma sorszáma
  
Relációk az adatok között: 
* Egy hallgatónak több dolgozatot is írhat más-más szakon. 
* Egy dolgozathoz több témavezető is tartozhat, a szerepkörben azt lehet eltárolni, hogy a témavezető külső vagy belső témavezető.

Bővebb működés:
https://github.com/Kinguska/Ab_project-szte-2023/blob/main/szakdolgozatok_dokumentacio.pdf
