// ignore_for_file: prefer_final_fields

import 'package:flutter/material.dart';

class insta extends StatefulWidget {
  @override
  State<insta> createState() => instastate();
}

class instastate extends State<insta> {
  List<String> _stories = ["", ""];

  List<bool> mausabangcolor = [false, false];

  List<String> _posts = [
    "REMOVE",
    "REMOVE",
    "REMOVE",
    "REMOVE",
    "REMOVE"
  ];

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
        debugShowCheckedModeBanner: false,
        home: Scaffold(
          appBar: AppBar(
            title: Text("INSTAGRAM"),
          ),
          body: Column(
            children: [
              Container(
                height: 80,
                child: ListView.builder(
                    scrollDirection: Axis.horizontal,
                    itemCount: _stories.length,
                    itemBuilder: (context, index) {
                      return GestureDetector(
                        onTap: () {
                          setState(() {
                            mausabangcolor[index] = !mausabangcolor[index];
                          });
                        },
                        onDoubleTap: () {
                          setState(() {
                            _stories.removeAt(index);
                          });
                        },
                        child: Padding(
                          padding: const EdgeInsets.all(4),
                          child: Container(
                            width: 80,
                            child: Center(
                              child: Text(
                                mausabangcolor[index]
                                    ? "GREEN"
                                    : "RED",
                                style: TextStyle(fontSize: 10),
                              ),
                            ),
                            decoration: BoxDecoration(
                                color: mausabangcolor[index]
                                    ? Color.fromARGB(255, 88, 228, 7)
                                    : Color.fromARGB(255, 255, 23, 15),
                                shape: BoxShape.circle),
                          ),
                        ),
                      );
                    }),
              ),
              Expanded(
                  child: ListView.builder(
                      itemCount: _posts.length,
                      itemBuilder: (context, index) {
                        return Padding(
                          padding: const EdgeInsets.only(top: 2, bottom: 4),
                          child: GestureDetector(
                            onTap: () {
                              setState(() {
                                _posts.removeAt(index);
                              });
                            },
                            child: Container(
                              height: 200,
                              color: const Color.fromARGB(255, 54, 238, 244),
                              child: Center(
                                child: Text(_posts[index]),
                              ),
                            ),
                          ),
                        );
                      }))
            ],
          ),
        ));
  }
}
