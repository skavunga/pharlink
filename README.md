# Sénario
Ton client veux que tu lui installe l'application que tu es en train de vendre, dans son réseau local.
Le problème qui se pose est qu'il n'a acheté qu'une licence d'utilisation et il n'a pas le droit de modifier ton application plus tard.
De ton côté, tu ne veux pas non plus mettre ton application écris en PHP dans son serveur en local, de peur que l'on te vole tes réalisations.

Ceci est la partie de la solution: La grande solution est d'utiliser [box]: https://github.com/box-project/box L'autre probleme qui se pose est que ton application sera compacté dans une archive et compressé, mais que l'accès ne sera pas possible depuis un navigateur.

C'est là qu'entre en jeux ce petit library. Qui va remplacer les fichiers par leurs équivalents compressé pour que les deux parties sortent gagnant (client et développeur).

# Utilisation
