# PRESTIGE V1 — open.mp game server

This directory contains the first open.mp game-server configuration and Pawn gamemode source.

## What this build includes

- PRESTIGE V1 server identity and query settings.
- UDP game port configured as `7777`.
- A small initial gamemode that accepts connections, provides a public spawn, and responds to `/help`.
- RCON disabled by default.

This is a **foundation build**, not a completed roleplay server. Registration, persistent player data, jobs, economy, vehicles, factions, moderation, and the production account system are not implemented yet.

## Requirements

- A Linux VPS or dedicated host with public UDP support.
- The official open.mp Linux server files.
- The open.mp Pawn compiler/toolchain to compile `gamemodes/prestige.pwn` into `gamemodes/prestige.amx`.

## Install and run

1. Install the official open.mp server on a supported Linux host, following the official Linux installation guide.
2. Copy this directory's `config.json` into the open.mp server root.
3. Copy `gamemodes/prestige.pwn` into the server's `gamemodes/` directory.
4. Compile it with the open.mp Pawn toolchain and place the result at `gamemodes/prestige.amx`.
5. Ensure the host firewall and provider firewall allow inbound **UDP 7777**.
6. Start `omp-server` from the server root.
7. Connect using the host's public IP or DNS name and UDP port `7777`.

## Important: current Clever Cloud application

The existing Clever Cloud application remains the web/API service and MySQL connectivity endpoint. Its TCP redirections forward raw **TCP** traffic to application port `4040`; they do not provide the UDP game endpoint required by the normal SA-MP/open.mp client protocol. The assigned TCP redirection ports (for example, `5343` or `14554`) must not be entered as the PRESTIGE game address.

Keep the current Clever Cloud web/API deployment and database. Run the open.mp process on a host that explicitly supports inbound UDP. The game server can then use the same MySQL database only after its database integration and network access are configured and tested.

## Security

- Do not commit database passwords, RCON passwords, SSH keys, or provider tokens.
- Keep RCON disabled unless remote administration is deliberately configured with a strong private password and network restrictions.
- Do not expose MySQL directly to the public internet.
