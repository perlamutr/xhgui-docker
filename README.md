# xhgui-docker

Docker image allow to you use xhgui as service inside its own container. 
Just provide your data provider to container's mongo instance.

## Table Of Contents
- [Usage](#usage)
    - [Executing as part of compose of containers](#executing-as-part-in-compose-of-containers)
    - [Executing as standalone container](#executing-as-standalone-container)
- [Roadmap for 1.0 version](#roadmap-for-10-version)

## Usage

### Executing as part in compose of containers

1. Configure your docker-compose.yml

```
version: "2"
services:
    web: ...
    
    backend:
        ...
        links: [db, xhgui]
        
    db: ...
     
    xhgui:
        image: cv21/xhgui
        ports: 
            - 8081:80
```

2. Build

```
docker-compose build .
```

3. Run

```
docker-compose up -d
```

4. Execute your php script

5. Open xhgui and see results

### Executing as standalone container
1. Execute docker image
```
$ docker run -d -p 8081:80 cv21:xhgui
```

2. Open link http://127.0.0.1:8081 and you will see

![](http://sc-cdn.scaleengine.net/i/5f8ee865a04afd593bb0e2437161e985.png)

## Roadmap for 1.0 version

- [ ] Update docs
- [ ] Allow to use xhgui codebase by in-folder code
- [ ] Allow to use xhgui codebase by composer
- [ ] Allow to use configs
