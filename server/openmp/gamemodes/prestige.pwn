#include <open.mp>

#define PRESTIGE_COLOR 0x8B5CF6FF
#define PRESTIGE_WHITE 0xFFFFFFFF

public OnGameModeInit()
{
    SetGameModeText("PRESTIGE Roleplay | V1");
    ShowPlayerMarkers(PLAYER_MARKERS_MODE_GLOBAL);
    ShowNameTags(true);
    SetWorldTime(12);
    SetWeather(10);

    // Initial public spawn: Los Santos Airport.
    AddPlayerClass(
        0,
        1958.3783, 1343.1572, 15.3746,
        269.15,
        0, 0, 0, 0, 0, 0
    );

    print("----------------------------------------");
    print(" PRESTIGE V1 - open.mp gamemode loaded");
    print(" Foundation build: connection and spawn");
    print("----------------------------------------");
    return 1;
}

public OnGameModeExit()
{
    print("PRESTIGE V1 gamemode stopped.");
    return 1;
}

public OnPlayerConnect(playerid)
{
    SendClientMessage(playerid, PRESTIGE_COLOR, "Welcome to PRESTIGE V1!");
    SendClientMessage(playerid, PRESTIGE_WHITE, "The server is in its initial foundation stage.");
    return 1;
}

public OnPlayerSpawn(playerid)
{
    SetPlayerHealth(playerid, 100.0);
    SetPlayerArmour(playerid, 0.0);
    SetPlayerInterior(playerid, 0);
    SetPlayerVirtualWorld(playerid, 0);
    SendClientMessage(playerid, PRESTIGE_COLOR, "You have spawned. Welcome!");
    return 1;
}

public OnPlayerCommandText(playerid, cmdtext[])
{
    if (!strcmp(cmdtext, "/help", true))
    {
        SendClientMessage(playerid, PRESTIGE_COLOR, "PRESTIGE V1 commands:");
        SendClientMessage(playerid, PRESTIGE_WHITE, "/help - show this help");
        SendClientMessage(playerid, PRESTIGE_WHITE, "More roleplay systems will be added in later builds.");
        return 1;
    }

    return 0;
}
