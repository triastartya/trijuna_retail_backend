#!/bin/bash
echo "Stopping and removing containers..."
docker compose down

echo "Delete Image"
docker rmi backend-frankenphp:latest

echo "Pulling latest changes from Git..."
git pull origin devlopment

echo "Starting containers with new changes..."
docker compose up --wait