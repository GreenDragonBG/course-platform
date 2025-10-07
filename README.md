# Course Platform

### 🚀 Setup & Run

To build and start the project, run:

```bash
docker-compose up -d --build
```

### ▶️ Start Docker Services

```bash
docker-compose start
```

### ⏹️ Stop Docker Services

```bash
docker-compose stop
```

### 🔁 Rebuild from Scratch

If you encounter issues, stop and remove all containers and volumes:

```bash
docker-compose down -v
```

Then rebuild and start again:

```bash
docker-compose up -d --build
```
