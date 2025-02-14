FROM nginx:1.20.2-alpine

LABEL maintainer="Harun <harun.rashid@technovista.com.bd>"

# Create working directory
WORKDIR /var/www/html

# New default conf containing the proxy config
COPY ./conf.d/default.conf /etc/nginx/conf.d/default.conf

# Copy the source code into the container
# COPY . /var/www/html

# Server will run on port 80
EXPOSE 80

# Dcoker command
CMD ["nginx", "-g", "daemon off;"]
