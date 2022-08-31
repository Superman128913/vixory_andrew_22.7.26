## SAMPLE NGINX CONFIGURATION
e. Configure nginx routing to funnel traffic to the backend/frontend. Below are the relevant location blocks.

    #Server block root is always set to public folder.
    root /home/mark/Sites/vixory/public;

    #Default location block for pages
    location / {
      root   /home/mark/Sites/vixory/public/dist;
      try_files $uri $uri/ /index.html;    
    }
    
    #Serve vendor files from public/vendor directory before serving normal assets from the dist directory.
    location ~ ^/(vendor|vixory) {
        root /home/mark/Sites/vixory/public;
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ /public/ {
        root /home/mark/Sites/vixory/;
        rewrite ^ /home/mark/.config/composer/vendor/cpriego/valet-linux/server.php last;
    }
    
    location ~* ^.+\.(css|js) {
        root   /home/mark/Sites/vixory/public/dist;
        try_files $uri $uri/ /index.php?$query_string;
    }

    #Docs
    location ~ /docs/ {
        rewrite ^ /home/mark/.config/composer/vendor/cpriego/valet-linux/server.php last;
    }
    
    location ~ ^/(login|logout|register|api|storage|sanctum/csrf-cookie|admin|nova-api|nova|telescope|horizon) {
        try_files $uri $uri/ /index.php?$query_string;
    }

f. Move into the ./resources/frontend file and run "npm install" and then "npm run dev"


## SAMPLE WINDOWS NGINX CONFIGURATION
    #Server block root is always set to public folder.
    root C:\sites\vixory;

    #Default location block for pages
    location / {
      root   /home/mark/Sites/vixory/public/dist;
      try_files $uri $uri/ /index.html;    
    }
    
    #Serve vendor files from public/vendor directory before serving normal assets from the dist directory.
    location ~ ^/(vendor|vixory) {
        root /home/mark/Sites/vixory/public;
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ /public/ {
        root /home/mark/Sites/vixory/;
        rewrite ^ /home/mark/.config/composer/vendor/cpriego/valet-linux/server.php last;
    }
    
    location ~* ^.+\.(css|js) {
        root   /home/mark/Sites/vixory/public/dist;
        try_files $uri $uri/ /index.php?$query_string;
    }

    #Docs
    location ~ /docs/ {
        rewrite ^ /home/mark/.config/composer/vendor/cpriego/valet-linux/server.php last;
    }
    
    location ~ ^/(login|logout|register|api|storage|sanctum/csrf-cookie|admin|nova-api|nova|telescope|horizon) {
        try_files $uri $uri/ /index.php?$query_string;
    }