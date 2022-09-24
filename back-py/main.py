from fastapi import FastAPI
from bs4 import BeautifulSoup as bs
import requests as req
import json

app = FastAPI()


@app.get('/api//photos')
def getPhotos(place_name):

    url_web = 'https://yandex.ru/images/search?from=tabbar&text=' + place_name

    with(req.get(url_web)) as resp:

        imgs = []

        if resp.status_code == 200:

            html = resp.text
            soup = bs(html, 'lxml')
            imgsHtml = soup.find_all('img', class_='serp-item__thumb')

            for img in imgsHtml:
                src = 'https:' + img['src']
                imgs.append(src)
                # print("{0}: {1}: {2}".format(img.name, img['class'], img['src']))

        else:
            imgs.append('error')

        imgs = json.dumps(imgs)
        return imgs
