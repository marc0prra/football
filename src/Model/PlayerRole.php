<?php

namespace src\Model;

enum PlayerRole: string
{
    case Attaquant = 'Attaquant';
    case Milieu = 'Milieu';
    case Défenseur = 'Défenseur';
    case Gardien = 'Gardien';
}
