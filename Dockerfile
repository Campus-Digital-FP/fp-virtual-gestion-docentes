# PHP 8.1 con FPM como imagen base
FROM php:8.1-fpm
LABEL MAINTAINER pablo <pabloruizsoria@gmail.com>

# Set the working directory in the container
WORKDIR /app

# Copy the requirements file to the container
# COPY requirements.txt .

# Install the dependencies
# RUN pip install --no-cache-dir -r requirements.txt

# Copy the application code to the container
COPY . .

# Expose the port the app runs on
EXPOSE 80

# Command to run the application
# CMD ["python", "app.py"]